<?php
session_start();
require_once '../../Database/database.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté']);
    exit;
}

$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents('php://input'), true);
$notification_id = isset($data['notification_id']) ? (int)$data['notification_id'] : null;
$mark_all = isset($data['mark_all']) ? (bool)$data['mark_all'] : false;

try {
    if ($mark_all) {
        // Marquer toutes les notifications comme lues
        $stmt = $conn->prepare("UPDATE notifications SET is_read = 1 WHERE user_id = ?");
        $stmt->execute([$user_id]);
    } else if ($notification_id) {
        // Marquer une notification spécifique comme lue
        $stmt = $conn->prepare("UPDATE notifications SET is_read = 1 WHERE id = ? AND user_id = ?");
        $stmt->execute([$notification_id, $user_id]);
    } else {
        echo json_encode(['success' => false, 'message' => 'ID de notification manquant']);
        exit;
    }
    
    echo json_encode(['success' => true, 'message' => 'Notification marquée comme lue']);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur: ' . $e->getMessage()]);
}
?>

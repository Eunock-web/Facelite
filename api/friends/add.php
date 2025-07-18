<?php
require_once '../../Database/database.php';
require_once '../notifications/create.php';
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté']);
    exit;
}
$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents('php://input'), true);
$ami_id = intval($data['ami_id'] ?? 0);

if (!$ami_id || $ami_id == $user_id) {
    echo json_encode(['success' => false, 'message' => 'ID ami invalide']);
    exit;
}

// Vérifier si déjà en relation
$stmt = $conn->prepare("SELECT * FROM amis WHERE (user_id = ? AND ami_id = ?) OR (user_id = ? AND ami_id = ?)");
$stmt->execute([$user_id, $ami_id, $ami_id, $user_id]);
if ($stmt->rowCount() > 0) {
    echo json_encode(['success' => false, 'message' => 'Déjà en relation']);
    exit;
}

try {
    // Ajouter la demande
    $stmt = $conn->prepare("INSERT INTO amis (user_id, ami_id, statut) VALUES (?, ?, 'pending')");
    $stmt->execute([$user_id, $ami_id]);
    
    // Créer une notification pour l'utilisateur qui reçoit la demande
    $stmt = $conn->prepare("SELECT firstname, lastname FROM users WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $from_user = $stmt->fetch();
    
    if ($from_user) {
        $from_user_name = $from_user['firstname'] . ' ' . $from_user['lastname'];
        $content = getNotificationContent('friend_request', $from_user_name);
        createNotification($ami_id, $user_id, 'friend_request', $content);
    }
    
    echo json_encode(['success' => true, 'message' => 'Demande envoyée']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur: ' . $e->getMessage()]);
}
?>

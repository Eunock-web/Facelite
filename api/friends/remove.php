<?php
require_once '../../Database/database.php';
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté']);
    exit;
}

$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents('php://input'), true);
$friend_id = intval($data['user_id'] ?? 0);

if (!$friend_id || $friend_id == $user_id) {
    echo json_encode(['success' => false, 'message' => 'ID ami invalide']);
    exit;
}

try {
    // Vérifier si l'amitié existe
    $stmt = $conn->prepare("SELECT * FROM amis WHERE (user_id = ? AND ami_id = ?) OR (user_id = ? AND ami_id = ?)");
    $stmt->execute([$user_id, $friend_id, $friend_id, $user_id]);
    
    if ($stmt->rowCount() == 0) {
        echo json_encode(['success' => false, 'message' => 'Amitié non trouvée']);
        exit;
    }
    
    // Supprimer l'amitié
    $stmt = $conn->prepare("DELETE FROM amis WHERE (user_id = ? AND ami_id = ?) OR (user_id = ? AND ami_id = ?)");
    $stmt->execute([$user_id, $friend_id, $friend_id, $user_id]);

    // Supprimer toutes les conversations privées entre les deux utilisateurs
    require_once '../message/Conversation.php';
    $conversation = new Conversation();
    $privateConv = $conversation->getPrivateConversation($user_id, $friend_id);
    if ($privateConv && isset($privateConv['id'])) {
        // Supprimer la conversation (ce qui supprime aussi les messages et participants via ON DELETE CASCADE)
        $conn->prepare("DELETE FROM conversations WHERE id = ?")->execute([$privateConv['id']]);
    }
    
    echo json_encode(['success' => true, 'message' => 'Ami supprimé avec succès']);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur: ' . $e->getMessage()]);
}
?> 
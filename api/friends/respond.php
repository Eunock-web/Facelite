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
$request_user_id = intval($data['request_user_id'] ?? 0);
$action = $data['action'] ?? ''; // 'accept' ou 'decline'

if (!$request_user_id || !in_array($action, ['accept', 'decline'])) {
    echo json_encode(['success' => false, 'message' => 'Données invalides']);
    exit;
}

try {
    // Vérifier que la demande existe
    $stmt = $conn->prepare("SELECT * FROM amis WHERE user_id = ? AND ami_id = ? AND statut = 'pending'");
    $stmt->execute([$request_user_id, $user_id]);
    $request = $stmt->fetch();
    
    if (!$request) {
        echo json_encode(['success' => false, 'message' => 'Demande non trouvée']);
        exit;
    }
    
    if ($action === 'accept') {
        // Accepter la demande
        $stmt = $conn->prepare("UPDATE amis SET statut = 'accepted' WHERE user_id = ? AND ami_id = ?");
        $stmt->execute([$request_user_id, $user_id]);
        
        // Créer une notification pour l'utilisateur qui a envoyé la demande
        $stmt = $conn->prepare("SELECT firstname, lastname FROM users WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $acceptor = $stmt->fetch();
        
        if ($acceptor) {
            $acceptor_name = $acceptor['firstname'] . ' ' . $acceptor['lastname'];
            $content = getNotificationContent('friend_accepted', $acceptor_name);
            createNotification($request_user_id, $user_id, 'friend_accepted', $content);
        }
        
        // Créer automatiquement une conversation entre les deux amis
        try {
            require_once '../message/Conversation.php';
            $conversation = new Conversation();
            $conversation->createPrivateConversation($request_user_id, $user_id);
        } catch (Exception $e) {
            // Log l'erreur mais ne pas faire échouer la réponse
            error_log("Erreur lors de la création de la conversation: " . $e->getMessage());
        }
        
        echo json_encode(['success' => true, 'message' => 'Demande acceptée']);
        
    } else {
        // Refuser la demande
        $stmt = $conn->prepare("UPDATE amis SET statut = 'declined' WHERE user_id = ? AND ami_id = ?");
        $stmt->execute([$request_user_id, $user_id]);
        
        echo json_encode(['success' => true, 'message' => 'Demande refusée']);
    }
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur: ' . $e->getMessage()]);
}
?> 
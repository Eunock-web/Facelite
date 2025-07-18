<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/Conversation.php';
require_once __DIR__ . '/Message.php';

try {
    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['user_id'])) {
        // Pour les tests, utiliser un ID par défaut
        $userId = 1; // À remplacer par l'ID réel de l'utilisateur connecté
    } else {
        $userId = $_SESSION['user_id'];
    }
    $conversation = new Conversation();
    $message = new Message();

    $method = $_SERVER['REQUEST_METHOD'];

    switch ($method) {
        case 'GET':
            // Récupérer les messages d'une conversation
            if (!isset($_GET['conversation_id'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'ID de conversation requis']);
                exit;
            }
            
            $conversationId = $_GET['conversation_id'];
            
            // Vérifier que l'utilisateur fait partie de la conversation
            if (!$conversation->isUserInConversation($userId, $conversationId)) {
                http_response_code(403);
                echo json_encode(['success' => false, 'message' => 'Accès non autorisé à cette conversation']);
                exit;
            }
            
            $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 50;
            $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
            
            $messages = $message->getConversationMessages($conversationId, $limit, $offset);
            
            // Marquer la conversation comme lue
            $conversation->markConversationAsRead($userId, $conversationId);
            
            echo json_encode([
                'success' => true,
                'messages' => $messages
            ]);
            break;
            
        case 'POST':
            // Envoyer un message
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($data['conversation_id']) || !isset($data['content'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'ID de conversation et contenu requis']);
                exit;
            }
            
            $conversationId = $data['conversation_id'];
            $content = trim($data['content']);
            $messageType = isset($data['message_type']) ? $data['message_type'] : 'text';
            $fileUrl = isset($data['file_url']) ? $data['file_url'] : null;
            
            if (empty($content)) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Le contenu du message ne peut pas être vide']);
                exit;
            }
            
            // Vérifier que l'utilisateur fait partie de la conversation
            if (!$conversation->isUserInConversation($userId, $conversationId)) {
                http_response_code(403);
                echo json_encode(['success' => false, 'message' => 'Accès non autorisé à cette conversation']);
                exit;
            }
            
            // Envoyer le message
            $newMessage = $message->sendMessage($conversationId, $userId, $content, $messageType, $fileUrl);
            
            echo json_encode([
                'success' => true,
                'message' => $newMessage
            ]);
            break;
            
        case 'DELETE':
            // Supprimer un message
            if (!isset($_GET['message_id'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'ID du message requis']);
                exit;
            }
            
            $messageId = $_GET['message_id'];
            
            // Supprimer le message
            $message->deleteMessage($messageId, $userId);
            
            echo json_encode([
                'success' => true,
                'message' => 'Message supprimé avec succès'
            ]);
            break;
            
        default:
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
            break;
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} 
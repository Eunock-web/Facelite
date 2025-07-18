<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/Conversation.php';
require_once __DIR__ . '/Message.php';

try {
    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['user_id'])) {
        // Pour les tests, utiliser un ID par défaut
       echo json_encode(['message'=>'Utilisateur non connecter']); // À remplacer par l'ID réel de l'utilisateur connecté
    } else {
        $userId = $_SESSION['user_id'];
    }
    $conversation = new Conversation();
    $message = new Message();

    $method = $_SERVER['REQUEST_METHOD'];

    switch ($method) {
        case 'GET':
            // Créer automatiquement des conversations pour tous les amis
            $conversation->createConversationsForAllFriends($userId);
            
            // Récupérer les conversations de l'utilisateur
            $conversations = $conversation->getUserConversations($userId);
            
            // Filtrer les conversations privées pour ne garder que celles où les deux sont encore amis
            foreach ($conversations as $k => $conv) {
                if ($conv['type'] === 'private' && isset($conv['participants']) && count($conv['participants']) === 2) {
                    $other = null;
                    foreach ($conv['participants'] as $p) {
                        if ($p['user_id'] != $userId) {
                            $other = $p['user_id'];
                            break;
                        }
                    }
                    if ($other && !$conversation->areUsersFriends($userId, $other)) {
                        unset($conversations[$k]);
                    }
                }
            }
            $conversations = array_values($conversations);
            // Enrichir avec les informations des participants
            foreach ($conversations as &$conv) {
                $participants = $conversation->getConversationParticipants($conv['id']);
                
                // Pour les conversations privées, récupérer l'autre participant
                if ($conv['type'] === 'private') {
                    $otherParticipant = null;
                    foreach ($participants as $participant) {
                        if ($participant['user_id'] != $userId) {
                            $otherParticipant = $participant;
                            break;
                        }
                    }
                    
                    if ($otherParticipant) {
                        $conv['other_user'] = [
                            'id' => $otherParticipant['user_id'],
                            'firstname' => $otherParticipant['firstname'],
                            'lastname' => $otherParticipant['lastname'],
                            'profil' => $otherParticipant['profil']
                        ];
                    }
                }
                
                $conv['participants'] = $participants;
                $conv['unread_count'] = $message->getUnreadCount($conv['id'], $userId);
            }
            
            echo json_encode([
                'success' => true,
                'conversations' => $conversations
            ]);
            break;
            
        case 'POST':
            // Créer une nouvelle conversation
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($data['other_user_id'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'ID de l\'autre utilisateur requis']);
                exit;
            }
            
            $otherUserId = $data['other_user_id'];
            
            // Vérifier que les deux utilisateurs sont amis
            if (!$conversation->areUsersFriends($userId, $otherUserId)) {
                http_response_code(403);
                echo json_encode(['success' => false, 'message' => 'Vous devez être amis pour pouvoir discuter']);
                exit;
            }
            
            // Créer la conversation privée
            $newConversation = $conversation->createPrivateConversation($userId, $otherUserId);
            
            // Récupérer les participants
            $participants = $conversation->getConversationParticipants($newConversation['id']);
            
            echo json_encode([
                'success' => true,
                'conversation' => $newConversation,
                'participants' => $participants
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
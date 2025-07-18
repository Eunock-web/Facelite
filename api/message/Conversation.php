<?php

require_once dirname(__DIR__, 2) . '/Database/database.php';

class Conversation {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Créer une nouvelle conversation privée
     */
    public function createPrivateConversation($user1Id, $user2Id) {
        try {
            // Vérifier si une conversation existe déjà entre ces deux utilisateurs
            $existingConversation = $this->getPrivateConversation($user1Id, $user2Id);
            if ($existingConversation) {
                return $existingConversation;
            }
            
            // Créer la nouvelle conversation
            $this->db->query(
                "INSERT INTO conversations (type) VALUES ('private')",
                []
            );
            
            $conversationId = $this->db->lastInsertId();
            
            // Ajouter les participants
            $this->db->query(
                "INSERT INTO conversation_participants (conversation_id, user_id) VALUES (?, ?), (?, ?)",
                [$conversationId, $user1Id, $conversationId, $user2Id]
            );
            
            return $this->getConversationById($conversationId);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la création de la conversation: " . $e->getMessage());
        }
    }
    
    /**
     * Récupérer une conversation privée entre deux utilisateurs
     */
    public function getPrivateConversation($user1Id, $user2Id) {
        try {
            $sql = "
                SELECT c.* 
                FROM conversations c
                INNER JOIN conversation_participants cp1 ON c.id = cp1.conversation_id
                INNER JOIN conversation_participants cp2 ON c.id = cp2.conversation_id
                WHERE c.type = 'private'
                AND cp1.user_id = ? AND cp2.user_id = ?
                AND cp1.user_id != cp2.user_id
            ";
            
            return $this->db->fetch($sql, [$user1Id, $user2Id]);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération de la conversation: " . $e->getMessage());
        }
    }
    
    /**
     * Récupérer toutes les conversations d'un utilisateur
     */
    public function getUserConversations($userId) {
        try {
            $sql = "
                SELECT 
                    c.*,
                    cp.last_read_at,
                    (
                        SELECT COUNT(*) 
                        FROM messages m 
                        WHERE m.conversation_id = c.id 
                        AND m.sender_id != ? 
                        AND m.created_at > COALESCE(cp.last_read_at, '1970-01-01')
                    ) as unread_count,
                    (
                        SELECT m.content 
                        FROM messages m 
                        WHERE m.conversation_id = c.id 
                        ORDER BY m.created_at DESC 
                        LIMIT 1
                    ) as last_message,
                    (
                        SELECT m.created_at 
                        FROM messages m 
                        WHERE m.conversation_id = c.id 
                        ORDER BY m.created_at DESC 
                        LIMIT 1
                    ) as last_message_time
                FROM conversations c
                INNER JOIN conversation_participants cp ON c.id = cp.conversation_id
                WHERE cp.user_id = ?
                ORDER BY (last_message_time IS NULL), last_message_time DESC
            ";
            
            return $this->db->fetchAll($sql, [$userId, $userId]);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération des conversations: " . $e->getMessage());
        }
    }
    
    /**
     * Récupérer une conversation par son ID
     */
    public function getConversationById($conversationId) {
        try {
            $sql = "SELECT * FROM conversations WHERE id = ?";
            return $this->db->fetch($sql, [$conversationId]);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération de la conversation: " . $e->getMessage());
        }
    }
    
    /**
     * Récupérer les participants d'une conversation
     */
    public function getConversationParticipants($conversationId) {
        try {
            $sql = "
                SELECT 
                    cp.*,
                    u.firstname,
                    u.lastname,
                    u.profil,
                    u.email
                FROM conversation_participants cp
                INNER JOIN users u ON cp.user_id = u.user_id
                WHERE cp.conversation_id = ?
            ";
            
            return $this->db->fetchAll($sql, [$conversationId]);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération des participants: " . $e->getMessage());
        }
    }
    
    /**
     * Vérifier si un utilisateur est participant d'une conversation
     */
    public function isUserInConversation($userId, $conversationId) {
        try {
            $sql = "SELECT COUNT(*) as count FROM conversation_participants WHERE user_id = ? AND conversation_id = ?";
            $result = $this->db->fetch($sql, [$userId, $conversationId]);
            return $result['count'] > 0;
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la vérification: " . $e->getMessage());
        }
    }
    
    /**
     * Marquer une conversation comme lue par un utilisateur
     */
    public function markConversationAsRead($userId, $conversationId) {
        try {
            $sql = "
                UPDATE conversation_participants 
                SET last_read_at = CURRENT_TIMESTAMP 
                WHERE user_id = ? AND conversation_id = ?
            ";
            
            $this->db->query($sql, [$userId, $conversationId]);
            return true;
        } catch (Exception $e) {
            throw new Exception("Erreur lors du marquage comme lu: " . $e->getMessage());
        }
    }
    
    /**
     * Vérifier si deux utilisateurs sont amis
     */
    public function areUsersFriends($user1Id, $user2Id) {
        try {
            $sql = "
                SELECT COUNT(*) as count 
                FROM amis 
                WHERE (user_id = ? AND ami_id = ? OR user_id = ? AND ami_id = ?) 
                AND statut = 'accepted'
            ";
            
            $result = $this->db->fetch($sql, [$user1Id, $user2Id, $user2Id, $user1Id]);
            return $result['count'] > 0;
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la vérification d'amitié: " . $e->getMessage());
        }
    }
    
    /**
     * Créer automatiquement des conversations pour tous les amis d'un utilisateur
     */
    public function createConversationsForAllFriends($userId) {
        try {
            // Récupérer tous les amis de l'utilisateur
            $sql = "
                SELECT DISTINCT 
                    CASE 
                        WHEN a.user_id = ? THEN a.ami_id
                        ELSE a.user_id
                    END as friend_id,
                    u.firstname,
                    u.lastname,
                    u.profil
                FROM amis a
                INNER JOIN users u ON (
                    CASE 
                        WHEN a.user_id = ? THEN a.ami_id
                        ELSE a.user_id
                    END = u.user_id
                )
                WHERE (a.user_id = ? OR a.ami_id = ?) 
                AND a.statut = 'accepted'
            ";
            
            $friends = $this->db->fetchAll($sql, [$userId, $userId, $userId, $userId]);
            
            $createdConversations = [];
            
            foreach ($friends as $friend) {
                // Vérifier si une conversation existe déjà
                $existingConversation = $this->getPrivateConversation($userId, $friend['friend_id']);
                
                if (!$existingConversation) {
                    // Créer une nouvelle conversation
                    $conversation = $this->createPrivateConversation($userId, $friend['friend_id']);
                    $createdConversations[] = $conversation;
                }
            }
            
            return $createdConversations;
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la création des conversations pour les amis: " . $e->getMessage());
        }
    }
} 
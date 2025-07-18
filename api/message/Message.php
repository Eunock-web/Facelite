<?php

require_once dirname(__DIR__, 2) . '/Database/database.php';
class Message {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Envoyer un message dans une conversation
     */
    public function sendMessage($conversationId, $senderId, $content, $messageType = 'text', $fileUrl = null) {
        try {
            $sql = "
                INSERT INTO messages (conversation_id, sender_id, content, message_type, file_url) 
                VALUES (?, ?, ?, ?, ?)
            ";
            
            $this->db->query($sql, [$conversationId, $senderId, $content, $messageType, $fileUrl]);
            
            $messageId = $this->db->lastInsertId();
            
            // Mettre à jour la date de modification de la conversation
            $this->db->query(
                "UPDATE conversations SET updated_at = CURRENT_TIMESTAMP WHERE id = ?",
                [$conversationId]
            );
            
            return $this->getMessageById($messageId);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de l'envoi du message: " . $e->getMessage());
        }
    }
    
    /**
     * Récupérer les messages d'une conversation
     */
    public function getConversationMessages($conversationId, $limit = 50, $offset = 0) {
        try {
            $sql = "
                SELECT 
                    m.*,
                    u.firstname,
                    u.lastname,
                    u.profil
                FROM messages m
                INNER JOIN users u ON m.sender_id = u.user_id
                WHERE m.conversation_id = ? AND m.is_deleted = FALSE
                ORDER BY m.created_at DESC
                LIMIT ? OFFSET ?
            ";
            
            $messages = $this->db->fetchAll($sql, [$conversationId, $limit, $offset]);
            
            // Inverser l'ordre pour avoir les plus anciens en premier
            return array_reverse($messages);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération des messages: " . $e->getMessage());
        }
    }
    
    /**
     * Récupérer un message par son ID
     */
    public function getMessageById($messageId) {
        try {
            $sql = "
                SELECT 
                    m.*,
                    u.firstname,
                    u.lastname,
                    u.profil
                FROM messages m
                INNER JOIN users u ON m.sender_id = u.user_id
                WHERE m.id = ? AND m.is_deleted = FALSE
            ";
            
            return $this->db->fetch($sql, [$messageId]);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération du message: " . $e->getMessage());
        }
    }
    
    /**
     * Supprimer un message (soft delete)
     */
    public function deleteMessage($messageId, $userId) {
        try {
            // Vérifier que l'utilisateur est bien l'expéditeur du message
            $message = $this->getMessageById($messageId);
            if (!$message || $message['sender_id'] != $userId) {
                throw new Exception("Vous ne pouvez pas supprimer ce message");
            }
            
            $sql = "UPDATE messages SET is_deleted = TRUE WHERE id = ?";
            $this->db->query($sql, [$messageId]);
            
            return true;
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la suppression du message: " . $e->getMessage());
        }
    }
    
    /**
     * Récupérer le nombre de messages non lus dans une conversation
     */
    public function getUnreadCount($conversationId, $userId) {
        try {
            $sql = "
                SELECT COUNT(*) as count
                FROM messages m
                WHERE m.conversation_id = ?
                AND m.sender_id != ?
                AND m.is_deleted = FALSE
                AND m.created_at > (
                    SELECT COALESCE(last_read_at, '1970-01-01')
                    FROM conversation_participants
                    WHERE conversation_id = ? AND user_id = ?
                )
            ";
            
            $result = $this->db->fetch($sql, [$conversationId, $userId, $conversationId, $userId]);
            return $result['count'];
        } catch (Exception $e) {
            throw new Exception("Erreur lors du comptage des messages non lus: " . $e->getMessage());
        }
    }
    
    /**
     * Récupérer les derniers messages de toutes les conversations d'un utilisateur
     */
    public function getLastMessagesForUser($userId) {
        try {
            $sql = "
                SELECT 
                    c.id as conversation_id,
                    m.content as last_message,
                    m.created_at as last_message_time,
                    m.sender_id,
                    u.firstname,
                    u.lastname
                FROM conversations c
                INNER JOIN conversation_participants cp ON c.id = cp.conversation_id
                LEFT JOIN (
                    SELECT 
                        conversation_id,
                        content,
                        created_at,
                        sender_id,
                        ROW_NUMBER() OVER (PARTITION BY conversation_id ORDER BY created_at DESC) as rn
                    FROM messages
                    WHERE is_deleted = FALSE
                ) m ON c.id = m.conversation_id AND m.rn = 1
                LEFT JOIN users u ON m.sender_id = u.user_id
                WHERE cp.user_id = ?
                ORDER BY m.created_at DESC NULLS LAST
            ";
            
            return $this->db->fetchAll($sql, [$userId]);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération des derniers messages: " . $e->getMessage());
        }
    }
} 
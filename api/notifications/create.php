<?php
require_once '../../Database/database.php';

function createNotification($user_id, $from_user_id, $type, $content, $post_id = null) {
    global $conn;
    
    try {
        $stmt = $conn->prepare("
            INSERT INTO notifications (user_id, from_user_id, type, content, post_id) 
            VALUES (?, ?, ?, ?, ?)
        ");
        
        $stmt->execute([$user_id, $from_user_id, $type, $content, $post_id]);
        
        return true;
    } catch (Exception $e) {
        error_log("Erreur création notification: " . $e->getMessage());
        return false;
    }
}

function getNotificationContent($type, $from_user_name) {
    switch ($type) {
        case 'friend_request':
            return "$from_user_name vous a envoyé une demande d'amitié";
        case 'friend_accepted':
            return "$from_user_name a accepté votre demande d'amitié";
        case 'like':
            return "$from_user_name a aimé votre publication";
        case 'comment':
            return "$from_user_name a commenté votre publication";
        case 'mention':
            return "$from_user_name vous a mentionné dans un commentaire";
        default:
            return "Nouvelle notification de $from_user_name";
    }
}
?>

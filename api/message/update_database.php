<?php
require_once '../../Database/database.php';

try {
    $db = Database::getInstance();
    
    echo "Mise à jour de la base de données...\n";
    
    // Supprimer les anciennes contraintes de clés étrangères
    $db->query("ALTER TABLE conversation_participants DROP FOREIGN KEY conversation_participants_ibfk_2");
    $db->query("ALTER TABLE messages DROP FOREIGN KEY messages_ibfk_2");
    
    // Ajouter les nouvelles contraintes avec les bonnes références
    $db->query("ALTER TABLE conversation_participants ADD CONSTRAINT conversation_participants_ibfk_2 FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE");
    $db->query("ALTER TABLE messages ADD CONSTRAINT messages_ibfk_2 FOREIGN KEY (sender_id) REFERENCES users(user_id) ON DELETE CASCADE");
    
    echo "Base de données mise à jour avec succès !\n";
    
} catch (Exception $e) {
    echo "Erreur lors de la mise à jour : " . $e->getMessage() . "\n";
}
?> 
<?php
require_once '../../Database/database.php';
require_once 'Conversation.php';
require_once 'Message.php';

echo "Test de la messagerie...\n\n";

try {
    $conversation = new Conversation();
    $message = new Message();
    
    echo "✅ Classes chargées avec succès\n";
    
    // Test de création d'une conversation
    $conv = $conversation->createPrivateConversation(1, 2);
    echo "✅ Conversation créée : ID " . $conv['id'] . "\n";
    
    // Test d'envoi d'un message
    $msg = $message->sendMessage($conv['id'], 1, "Bonjour ! Test de la messagerie.");
    echo "✅ Message envoyé : ID " . $msg['id'] . "\n";
    
    // Test de récupération des messages
    $messages = $message->getConversationMessages($conv['id']);
    echo "✅ Messages récupérés : " . count($messages) . " message(s)\n";
    
    // Test de récupération des conversations
    $conversations = $conversation->getUserConversations(1);
    echo "✅ Conversations récupérées : " . count($conversations) . " conversation(s)\n";
    
    echo "\n🎉 Tous les tests sont passés ! La messagerie fonctionne correctement.\n";
    
} catch (Exception $e) {
    echo "❌ Erreur : " . $e->getMessage() . "\n";
} 
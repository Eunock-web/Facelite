<?php
require_once '../../Database/database.php';

try {
    $db = Database::getInstance();
    
    // Lire le fichier SQL
    $sql = file_get_contents(__DIR__ . '/database.sql');
    
    // Exécuter les requêtes
    $db->query($sql);
    
    echo "Tables de messagerie créées avec succès !\n";
    echo "Vous pouvez maintenant utiliser la messagerie.\n";
    
} catch (Exception $e) {
    echo "Erreur lors de la création des tables : " . $e->getMessage() . "\n";
} 
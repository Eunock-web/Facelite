<?php
require_once '../../Database/database.php';
session_start();
header('Content-Type: application/json');

if(!isset($_SESSION['user_id'])){
    echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté']);
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    // Récupérer les suggestions d'amis (utilisateurs non amis)
    $sql = "
    SELECT u.user_id, u.firstname, u.lastname, u.profil
    FROM users u
    WHERE u.user_id != ? 
    AND u.is_validated = 1
    AND u.user_id NOT IN (
        SELECT ami_id FROM amis WHERE user_id = ? 
        UNION
        SELECT user_id FROM amis WHERE ami_id = ?
    )
    LIMIT 20
    ";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_id, $user_id, $user_id]);
    $suggestions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode(['success' => true, 'suggestions' => $suggestions]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur: ' . $e->getMessage()]);
}
?>
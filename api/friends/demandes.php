<?php
require_once '../../Database/database.php';
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté']);
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    // Récupérer les demandes d'amis reçues (statut 'pending')
    $sql = "
    SELECT a.user_id, u.firstname, u.lastname, u.profil, a.statut, a.created_at
    FROM amis a
    INNER JOIN users u ON a.user_id = u.user_id
    WHERE a.ami_id = ? AND a.statut = 'pending'
    ORDER BY a.created_at DESC
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_id]);
    $demandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'demandes' => $demandes]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur: ' . $e->getMessage()]);
} 
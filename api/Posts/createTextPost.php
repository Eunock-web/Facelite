<?php
require_once '../../Database/database.php';
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté']);
    exit;
}
$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents('php://input'), true);
$description = trim($data['description'] ?? '');
if (!$description) {
    echo json_encode(['success' => false, 'message' => 'Le texte du post est vide.']);
    exit;
}
try {
    $stmt = $conn->prepare("INSERT INTO post (user_id, description, type_post, created_at) VALUES (?, ?, 'text', NOW())");
    $stmt->execute([$user_id, $description]);
    echo json_encode(['success' => true, 'message' => 'Post publié !']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur: ' . $e->getMessage()]);
} 
<?php
require_once '../../Database/database.php';
session_start();
header('Content-Type: application/json');

$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : ($_SESSION['user_id'] ?? 0);
if (!$user_id) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non trouvé']);
    exit;
}

// On suppose que les vidéos sont dans la table post avec type_post = 'video'
$stmt = $conn->prepare("SELECT post_id, content, description, created_at 
    FROM post 
    WHERE user_id = ? AND type_post = 'video'
    ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$videos = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['success' => true, 'videos' => $videos]);

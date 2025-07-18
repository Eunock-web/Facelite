<?php
require_once '../../Database/database.php';
session_start();
header('Content-Type: application/json');

$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : ($_SESSION['user_id'] ?? 0);
if (!$user_id) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non trouvé']);
    exit;
}

$stmt = $conn->prepare("SELECT p.*, u.firstname, u.lastname, u.profil 
    FROM post p 
    JOIN users u ON p.user_id = u.user_id 
    WHERE p.user_id = ? 
    ORDER BY p.created_at DESC");
$stmt->execute([$user_id]);
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['success' => true, 'posts' => $posts]);

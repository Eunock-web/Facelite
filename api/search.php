<?php
require_once '../Database/database.php';
header('Content-Type: application/json');

$input = file_get_contents('php://input');
$data = json_decode($input, true);
$keyword = isset($data['keyword']) ? trim($data['keyword']) : '';

if ($keyword === '') {
    echo json_encode(['success' => false, 'results' => [], 'message' => 'Aucun mot-clé fourni']);
    exit;
}

try {
    // Recherche utilisateurs
    $stmt = $conn->prepare("SELECT user_id, firstname, lastname, profil FROM users WHERE firstname LIKE ? OR lastname LIKE ? LIMIT 10");
    $stmt->execute(["%$keyword%", "%$keyword%"]);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Recherche posts
    $stmt = $conn->prepare("SELECT post_id, description, content, type_post FROM post WHERE description LIKE ? LIMIT 10");
    $stmt->execute(["%$keyword%"]);
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'results' => [
            'users' => $users,
            'posts' => $posts
        ]
    ]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'results' => [], 'message' => $e->getMessage()]);
} 
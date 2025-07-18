<?php
session_start();
require_once '../../Database/database.php';
header('Content-Type: application/json');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Utilisateur non connecté']);
    exit();
}

// Récupérer l'ID du post
$postId = isset($_GET['postId']) ? (int)$_GET['postId'] : null;
if (!$postId) {
    http_response_code(400);
    echo json_encode(['error' => 'ID du post manquant']);
    exit();
}

try {
    // 1. Récupérer d'abord le post
    $stmt = $conn->prepare("
        SELECT 
            p.*, 
            u.firstname as post_firstname,
            u.lastname as post_lastname,
            u.profil as post_user_avatar,
            (SELECT COUNT(*) FROM likes WHERE post_id = p.post_id) as post_likes_count,
            (SELECT COUNT(*) FROM likes WHERE post_id = p.post_id AND user_id = ?) as post_is_liked
        FROM post p
        INNER JOIN users u ON p.user_id = u.user_id
        WHERE p.post_id = ?
    ");
    
    $stmt->execute([$_SESSION['user_id'], $postId]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$post) {
        http_response_code(404);
        echo json_encode(['error' => 'Post non trouvé']);
        exit();
    }

    // 2. Récupérer les commentaires
    $stmt = $conn->prepare("
        SELECT 
            c.*, 
            u.firstname,
            u.lastname,
            u.profil as user_avatar,
            (SELECT COUNT(*) FROM likes WHERE post_id = c.id) as likes_count,
            (SELECT COUNT(*) FROM likes WHERE post_id = c.id AND user_id = ?) as is_liked
        FROM commentaires c
        INNER JOIN users u ON c.user_id = u.user_id
        WHERE c.post_id = ?
        ORDER BY c.created_at DESC
    ");
    
    $stmt->execute([$_SESSION['user_id'], $postId]);
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Vérifier si la requête a réussi
    if ($stmt->errorCode() !== '00000') {
        throw new Exception('Erreur lors de la requête SQL');
    }
    
    // Ajouter les informations de l'utilisateur connecté
    foreach($comments as &$comment) {
        $comment['is_owner'] = $comment['user_id'] == $_SESSION['user_id'];
    }

    // Construire la réponse
    $response = [
        'post' => $post,
        'comments' => $comments
    ];

    echo json_encode($response);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur serveur: ' . $e->getMessage()]);
}
<?php
require_once '../../Database/database.php';
require_once '../notifications/create.php';
header('Content-Type: application/json');

// Démarrer la session si pas déjà fait
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté']);
    exit;
}

// Récupérer les données POST
$data = json_decode(file_get_contents('php://input'), true);
$user_id = isset($data['user_id']) ? intval($data['user_id']) : $_SESSION['user_id'];
$post_id = isset($data['post_id']) ? intval($data['post_id']) : 0;

// Log pour déboguer
error_log("Like request - user_id: $user_id, post_id: $post_id");

if (!$user_id || !$post_id) {
    echo json_encode(['success' => false, 'message' => 'Données manquantes ou utilisateur non connecté']);
    exit;
}

try {
    // Vérifier si le like existe déjà
    $stmt = $conn->prepare("SELECT id FROM likes WHERE user_id = ? AND post_id = ?");
    $stmt->execute([$user_id, $post_id]);
    $existing_like = $stmt->fetch();

    if ($existing_like) {
        // Déjà liké, donc on retire le like (toggle)
        $stmt = $conn->prepare("DELETE FROM likes WHERE user_id = ? AND post_id = ?");
        $stmt->execute([$user_id, $post_id]);
        $liked = false;
        error_log("Like removed for user $user_id on post $post_id");
    } else {
        // Pas encore liké, on ajoute le like
        $stmt = $conn->prepare("INSERT INTO likes (user_id, post_id) VALUES (?, ?)");
        $stmt->execute([$user_id, $post_id]);
        $liked = true;
        error_log("Like added for user $user_id on post $post_id");
        
        // Créer une notification pour le propriétaire du post
        if ($liked) {
            // Récupérer le user_id du propriétaire du post
            $stmt = $conn->prepare("SELECT user_id FROM post WHERE post_id = ?");
            $stmt->execute([$post_id]);
            $post_owner = $stmt->fetch();
            
            if ($post_owner && $post_owner['user_id'] != $user_id) {
                // Récupérer le nom de l'utilisateur qui like
                $stmt = $conn->prepare("SELECT firstname, lastname FROM users WHERE user_id = ?");
                $stmt->execute([$user_id]);
                $from_user = $stmt->fetch();
                
                if ($from_user) {
                    $from_user_name = $from_user['firstname'] . ' ' . $from_user['lastname'];
                    $content = getNotificationContent('like', $from_user_name);
                    createNotification($post_owner['user_id'], $user_id, 'like', $content, $post_id);
                }
            }
        }
    }

    // Compter le nombre de likes pour ce post
    $stmt = $conn->prepare("SELECT COUNT(*) as like_count FROM likes WHERE post_id = ?");
    $stmt->execute([$post_id]);
    $result = $stmt->fetch();
    $like_count = $result['like_count'];

    echo json_encode([
        'success' => true,
        'liked' => $liked,
        'like_count' => $like_count
    ]);

} catch (Exception $e) {
    error_log("Error in likePost.php: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Erreur lors du traitement du like: ' . $e->getMessage()
    ]);
}
?>
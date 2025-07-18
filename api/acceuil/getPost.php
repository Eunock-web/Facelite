<?php
    session_start();
    require_once '../../Database/database.php';
    header('Content-Type: application/json');

    if(!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])){
        http_response_code(401);
        echo json_encode(['message' => 'Utilisateur non connecté']);
        exit();
    }

    $postId = isset($_GET['id']) ? (int)$_GET['id'] : null;
    $user_id = $_SESSION['user_id'];

    try {
        if(isset($postId)) {
            // Récupération d'un post unique avec les likes et le nombre de commentaires
            $query = "SELECT 
                post.*, 
                users.firstname,
                users.lastname,
                users.profil,
                (SELECT COUNT(*) FROM likes WHERE post_id = post.post_id) as likes_count,
                (SELECT COUNT(*) FROM likes WHERE post_id = post.post_id AND user_id = ?) as is_liked,
                (SELECT COUNT(*) FROM commentaires WHERE post_id = post.post_id) as comments_count
            FROM post 
            INNER JOIN users ON post.user_id = users.user_id 
            WHERE post.post_id = ? 
            ORDER BY post.created_at DESC";
            
            $stmt = $conn->prepare($query);
            $stmt->execute([$user_id, $postId]);
            $post = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if($post) {
                $post['is_owner'] = $post['user_id'] == $user_id;
                $post['is_liked'] = $post['is_liked'] > 0;
                echo json_encode($post);
            } else {
                echo json_encode(['message' => 'Post non trouvé']);
            }
        } else {
            // Récupération de tous les posts avec les likes et le nombre de commentaires
            $query = "SELECT 
                post.*, 
                users.firstname,
                users.lastname,
                users.profil,
                (SELECT COUNT(*) FROM likes WHERE post_id = post.post_id) as likes_count,
                (SELECT COUNT(*) FROM likes WHERE post_id = post.post_id AND user_id = ?) as is_liked,
                (SELECT COUNT(*) FROM commentaires WHERE post_id = post.post_id) as comments_count
            FROM post 
            INNER JOIN users ON post.user_id = users.user_id 
            ORDER BY post.created_at DESC";
            
            $stmt = $conn->prepare($query);
            $stmt->execute([$user_id]);
            $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Ajouter les informations de l'utilisateur connecté
            foreach($posts as &$post) {
                $post['is_owner'] = $post['user_id'] == $user_id;
                $post['is_liked'] = $post['is_liked'] > 0;
            }
            
            echo json_encode($posts);
        }
    } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(['message' => 'Erreur lors de la récupération des posts: ' . $e->getMessage()]);
    }
?>
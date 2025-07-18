<?php
header('Content-Type: application/json');
require_once '../../Database/database.php';

// Vérifier si la requête est bien POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
    exit;
}

// Démarrer la session
session_start();
$user_id = $_SESSION['user_id'];

// Vérifier si l'utilisateur est connecté
if (!isset($user_id)) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Non authentifié']);
    exit;
}

// Vérifier les données reçues
$hasFile = isset($_FILES['media']) && $_FILES['media']['error'] === UPLOAD_ERR_OK;
$hasDescription = isset($_POST['description']) && !empty(trim($_POST['description']));

if (!$hasFile && !$hasDescription) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Données manquantes']);
    exit;
}

// Configuration
$uploadDir_Image = "../../assets/imagePost";
$uploadDir_Video = "../../assets/videoPost";
$allowedImageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
$allowedVideoTypes = ['video/mp4', 'video/webm', 'video/ogg'];
$maxFileSize = 10 * 1024 * 1024; // 10MB

// Créer les dossiers d'upload s'ils n'existent pas
if (!file_exists($uploadDir_Image)) {
    mkdir($uploadDir_Image, 0777, true);
}
if (!file_exists($uploadDir_Video)) {
    mkdir($uploadDir_Video, 0777, true);
}

try {
    // Récupérer les données
    $description = $hasDescription ? htmlspecialchars($_POST['description']) : '';
    $mediaFile = $hasFile ? $_FILES['media'] : null;

    $responseData = [
        'success' => true,
        'message' => 'Publication créée avec succès',
        'mediaPath' => null,
        'description' => $description
    ];

    // Traitement du média s'il existe
    if ($mediaFile && $mediaFile['error'] === UPLOAD_ERR_OK) {
        // Validation du fichier
        $fileType = mime_content_type($mediaFile['tmp_name']);
        $fileSize = $mediaFile['size'];
        $fileExtension = strtolower(pathinfo($mediaFile['name'], PATHINFO_EXTENSION));

        // Vérification du type et taille
        if (!in_array($fileType, $allowedImageTypes) && !in_array($fileType, $allowedVideoTypes)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Type de fichier non supporté']);
            exit;
        }

        if ($fileSize > $maxFileSize) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Fichier trop volumineux (max 10MB)']);
            exit;
        }

        // Déterminer si c'est une image ou une vidéo
        $isImage = in_array($fileType, $allowedImageTypes);
        $uploadDir = $isImage ? $uploadDir_Image : $uploadDir_Video;
        $publicPath = ($isImage ? '/assets/imagePost/' : '/assets/videoPost/');

        // Générer un nom de fichier unique
        $fileName = uniqid('post_') . '_' . $user_id . '.' . $fileExtension;
        $filePath = $uploadDir . '/' . $fileName;

        // Déplacer le fichier uploadé
        if (move_uploaded_file($mediaFile['tmp_name'], $filePath)) {
            $responseData['mediaPath'] = $publicPath . $fileName;
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'upload du fichier']);
            exit;
        }
    }

    // Insertion dans la base de données
    try {
        $type_post = null;
        if (isset($responseData['mediaPath'])) {
            $type_post = strpos($responseData['mediaPath'], 'imagePost') !== false ? 'image' : 'video';
        }

        $req = $conn->prepare("INSERT INTO Post (user_id, content, description, type_post) VALUES (?, ?, ?, ?)");
        $req->execute([
            $user_id,
            $responseData['mediaPath'] ?? null,
            $description,
            $type_post
        ]);

        // Récupérer l'ID du post créé
        $post_id = $conn->lastInsertId();

        // Créer une notification pour l'utilisateur
        $conn->prepare("INSERT INTO notifications (user_id, from_user_id, type, content, post_id, created_at) VALUES (?, ?, ?, ?, ?, NOW())")->execute([
            $user_id,
            $user_id,
            'post',
            'Vous avez publié un nouveau post',
            $post_id
        ]);

        // Récupérer la liste des amis
        $stmt = $conn->prepare("
            SELECT DISTINCT CASE 
                WHEN user_id = ? THEN ami_id 
                ELSE user_id 
            END as friend_id 
            FROM amis 
            WHERE (user_id = ? OR ami_id = ?) 
            AND statut = 'accepted'
        ");
        $stmt->execute([$user_id, $user_id, $user_id]);
        $friends = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Créer une notification pour chaque ami
        foreach ($friends as $friend) {
            $conn->prepare("INSERT INTO notifications (user_id, from_user_id, type, content, post_id, created_at) VALUES (?, ?, ?, ?, ?, NOW())")->execute([
                $friend['friend_id'],
                $user_id,
                'post',
                'a publié un nouveau post',
                $post_id
            ]);
        }

    } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'insertion : ' . $e->getMessage()]);
        exit;
    }

    echo json_encode($responseData);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erreur serveur: ' . $e->getMessage()]);
}
?>
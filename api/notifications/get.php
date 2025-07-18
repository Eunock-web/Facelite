<?php
session_start();
require_once '../../Database/database.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté']);
    exit;
}

$user_id = $_SESSION['user_id'];
$filter = isset($_GET['filter']) && in_array($_GET['filter'], ['all', 'unread']) ? $_GET['filter'] : 'all';
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 20;
$limit = max(1, min($limit, 100)); // Limite entre 1 et 100

try {
    // Configurer PDO pour lancer des exceptions
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "
        SELECT 
            n.*,
            u.firstname,
            u.lastname,
            u.profil as from_user_avatar,
            p.content as post_content,
            p.type_post as post_type
        FROM notifications n
        LEFT JOIN users u ON n.from_user_id = u.user_id
        LEFT JOIN post p ON n.post_id = p.post_id
        WHERE n.user_id = :user_id
    ";
    
    if ($filter === 'unread') {
        $sql .= " AND n.is_read = 0";
    }
    
    $sql .= " ORDER BY n.created_at DESC LIMIT :limit";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Compter les notifications non lues
    $stmt = $conn->prepare("SELECT COUNT(*) as unread_count FROM notifications WHERE user_id = :user_id AND is_read = 0");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $unread_count = $stmt->fetch(PDO::FETCH_ASSOC)['unread_count'];
    
    echo json_encode([
        'success' => true,
        'notifications' => $notifications,
        'unread_count' => (int)$unread_count
    ]);
    
} catch (PDOException $e) {
    error_log('Database error: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Erreur de base de données']);
} catch (Exception $e) {
    error_log('Error: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Erreur interne']);
}
?>
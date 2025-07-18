<?php
require_once '../../Database/database.php';
session_start();
header('Content-Type: application/json');

$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : ($_SESSION['user_id'] ?? 0);
if (!$user_id) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non trouvé']);
    exit;
}

$stmt = $conn->prepare("
    SELECT u.user_id, u.firstname, u.lastname, u.profil
    FROM amis a
    JOIN users u ON (u.user_id = IF(a.user_id = ?, a.ami_id, a.user_id))
    WHERE (a.user_id = ? OR a.ami_id = ?) AND a.statut = 'accepted'
    ORDER BY u.firstname, u.lastname
");
$stmt->execute([$user_id, $user_id, $user_id]);
$friends = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['success' => true, 'friends' => $friends]);

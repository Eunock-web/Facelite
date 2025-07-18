<?php
require_once '../../Database/database.php';
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté']);
    exit;
}
$user_id = $_SESSION['user_id'];

// Suggestions = tous les utilisateurs sauf moi et ceux déjà amis ou en attente
$sql = "
SELECT u.user_id, u.firstname, u.lastname, u.profil
FROM users u
WHERE u.user_id != ?
AND u.user_id NOT IN (
    SELECT ami_id FROM amis WHERE user_id = ? 
    UNION
    SELECT user_id FROM amis WHERE ami_id = ?
)
";
$stmt = $conn->prepare($sql);
$stmt->execute([$user_id, $user_id, $user_id]);
$suggestions = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['success' => true, 'suggestions' => $suggestions]);
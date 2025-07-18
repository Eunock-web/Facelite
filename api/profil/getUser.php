<?php
require_once '../../Database/database.php';
session_start();
header('Content-Type: application/json');

// Récupérer l'ID de l'utilisateur depuis l'URL
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : null;

if (!$user_id) {
    echo json_encode(['success' => false, 'message' => 'ID utilisateur requis']);
    exit;
}

// 1. Infos de base
$stmt = $conn->prepare("SELECT user_id, firstname, lastname, email, profil, couverture, created_at FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non trouvé']);
    exit;
}

// 2. Infos détaillées
$stmt = $conn->prepare("SELECT * FROM informations WHERE user_id = ?");
$stmt->execute([$user_id]);
$infos = $stmt->fetch(PDO::FETCH_ASSOC);

// Si pas d'informations détaillées, créer un objet vide avec des valeurs par défaut
if (!$infos) {
    $infos = [
        'job_title' => 'À compléter',
        'company' => 'À compléter',
        'education' => 'À compléter',
        'hometown' => 'À compléter',
        'location' => 'À compléter',
        'phone' => 'À compléter',
        'birth_date' => 'À compléter',
        'gender' => 'À compléter',
        'relationship_status' => 'À compléter',
        'bio' => 'À compléter',
        'website' => 'À compléter'
    ];
} else {
    // Remplacer les valeurs NULL par "À compléter"
    $fields_to_check = ['job_title', 'company', 'education', 'hometown', 'location', 'phone', 'birth_date', 'gender', 'relationship_status', 'bio', 'website'];
    foreach ($fields_to_check as $field) {
        if (empty($infos[$field])) {
            $infos[$field] = 'À compléter';
        }
    }
}

// 3. Nombre d'amis et liste des amis (4 premiers)
$stmt = $conn->prepare("
    SELECT u.user_id, u.firstname, u.lastname, u.profil
    FROM amis a
    JOIN users u ON (u.user_id = IF(a.user_id = ?, a.ami_id, a.user_id))
    WHERE (a.user_id = ? OR a.ami_id = ?) AND a.statut = 'accepted'
    LIMIT 4
");
$stmt->execute([$user_id, $user_id, $user_id]);
$friends = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SELECT COUNT(*) FROM amis WHERE (user_id = ? OR ami_id = ?) AND statut = 'accepted'");
$stmt->execute([$user_id, $user_id]);
$nb_amis = $stmt->fetchColumn();

// 4. Statut d'amitié (si ce n'est pas le sien)
$current_user_id = $_SESSION['user_id'] ?? null;
$is_own_profile = $current_user_id == $user_id;
$friend_status = null;

if (!$is_own_profile && $current_user_id) {
    $stmt = $conn->prepare("SELECT statut FROM amis WHERE (user_id = ? AND ami_id = ?) OR (user_id = ? AND ami_id = ?)");
    $stmt->execute([$current_user_id, $user_id, $user_id, $current_user_id]);
    $friend_status = $stmt->fetchColumn();
}

echo json_encode([
    'success' => true,
    'user' => $user,
    'infos' => $infos,
    'friends' => $friends,
    'nb_amis' => $nb_amis,
    'is_own_profile' => $is_own_profile,
    'friend_status' => $friend_status
]); 
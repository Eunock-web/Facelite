<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté']);
    exit;
}

require_once dirname(__DIR__, 2) . '/Database/database.php';

$type = $_POST['type'] ?? '';
if (!in_array($type, ['profil', 'cover'])) {
    echo json_encode(['success' => false, 'message' => 'Type invalide']);
    exit;
}
if (!isset($_FILES['photo'])) {
    echo json_encode(['success' => false, 'message' => 'Aucun fichier']);
    exit;
}

$ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
$filename = uniqid() . '.' . $ext;
$target = $type === 'profil' ? '../../assets/profil/' : '../../assets/couverture/';

if (!move_uploaded_file($_FILES['photo']['tmp_name'], $target . $filename)) {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'upload']);
    exit;
}

// Détermine la colonne et l'URL à enregistrer
if ($type === 'profil') {
    $col = 'profil';
    $url = 'assets/profil/' . $filename;
} else {
    $col = 'couverture';
    $url = 'assets/couverture/' . $filename;
}

// Met à jour la BDD
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("UPDATE users SET $col = :url WHERE user_id = :user_id");
$stmt->execute(['url' => $url, 'user_id' => $user_id]);

echo json_encode(['success' => true, 'url' => $url]);

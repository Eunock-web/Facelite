<?php
header('Content-Type: application/json');
$input = file_get_contents("php://input");
$data = json_decode($input, true);
require_once '../../Database/database.php';

if (!isset($data) || !isset($data['verification_code'])) {
    echo json_encode(['success' => false, 'message' => 'Les données n\'ont pas pu être envoyées']);
    exit;
}
    
$code = $data['verification_code'];

// Vérifier le code et qu'il n'a pas expiré
$req = $conn->prepare("SELECT * FROM users WHERE code_verification = ? AND code_expiry > NOW()");
$req->execute([$code]);

if ($req->rowCount() > 0) {
    $user = $req->fetch();
    
    // On annule le code de vérification pour ce user
    $update = $conn->prepare("UPDATE users SET code_verification = NULL, is_validated = 1 WHERE user_id = ?");
    $update->execute([$user['user_id']]);

    // Démarrer la session si elle n'est pas déjà démarrée
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    $_SESSION['user_id'] = $user['user_id'];
    echo json_encode(['success' => true, 'message' => 'Code de vérification correct']);
} else {
    // Vérifier si le code existe mais a expiré
    $reqExpired = $conn->prepare("SELECT * FROM users WHERE code_verification = ?");
    $reqExpired->execute([$code]);
    
    if ($reqExpired->rowCount() > 0) {
        echo json_encode(['success' => false, 'message' => 'Code de vérification expiré. Veuillez demander un nouveau code.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Code de vérification incorrect']);
    }
}
?>
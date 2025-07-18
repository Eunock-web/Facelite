<?php
session_start();
require_once '../../Database/database.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Vous devez être connecté pour effectuer cette action']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (empty($data['email']) || empty($data['password']) || empty($data['confirmPassword'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Tous les champs sont requis']);
    exit;
}

// Validation des données
$errors = [];

// Validation de l'email
if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'L\'adresse email n\'est pas valide';
}

// Validation du mot de passe
if (strlen($data['password']) < 8) {
    $errors[] = 'Le mot de passe doit contenir au moins 8 caractères';
}

// Vérification de la confirmation du mot de passe
if ($data['password'] !== $data['confirmPassword']) {
    $errors[] = 'Les mots de passe ne correspondent pas';
}

if (!empty($errors)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Veuillez corriger les erreurs suivantes :',
        'errors' => $errors
    ]);
    exit;
}

try {
    // Vérifier si l'email existe déjà
    $stmt = $conn->prepare('SELECT id FROM users WHERE email = ? AND id != ?');
    $stmt->execute([$data['email'], $_SESSION['user_id']]);
    
    if ($stmt->fetch()) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Cette adresse email est déjà utilisée'
        ]);
        exit;
    }

    // Hasher le nouveau mot de passe
    $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

    // Mettre à jour les informations de l'utilisateur
    $stmt = $conn->prepare('UPDATE users SET email = ?, password = ? WHERE id = ?');
    $stmt->execute([$data['email'], $hashedPassword, $_SESSION['user_id']]);

    echo json_encode([
        'success' => true,
        'message' => 'Vos informations ont été mises à jour avec succès'
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Une erreur est survenue lors de la mise à jour'
    ]);
}
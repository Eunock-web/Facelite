<?php
session_start();
header('Content-Type: application/json');
require_once '../../Database/database.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Non autorisé']);
    exit;
}

$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Données manquantes']);
    exit;
}

// Champs attendus
$firstname = trim($data['firstname'] ?? '');
$lastname = trim($data['lastname'] ?? '');
$email = trim($data['email'] ?? '');
$bio = trim($data['bio'] ?? '');
$phone = trim($data['phone'] ?? '');
$visibility = $data['visibility'] ?? 'public';
$show_email = !empty($data['show_email']) ? 1 : 0;
$job_title = trim($data['job_title'] ?? '');
$company = trim($data['company'] ?? '');
$education = trim($data['education'] ?? '');
$relationship_status = trim($data['relationship_status'] ?? 'À compléter');
$website = trim($data['website'] ?? '');
$location = trim($data['location'] ?? '');
$hometown = trim($data['hometown'] ?? '');
$graduation_year = trim($data['graduation_year'] ?? '');
$birth_date = trim($data['birth_date'] ?? '');
$gender = trim($data['gender'] ?? '');

// 1. Mettre à jour la table users (nom, prénom, email)
$stmt = $conn->prepare("UPDATE users SET firstname = ?, lastname = ?, email = ? WHERE user_id = ?");
$stmt->execute([$firstname, $lastname, $email, $user_id]);

// 2. Mettre à jour la table informations (bio, phone, visibility, show_email, job_title, company, education, relationship_status)
$stmt = $conn->prepare("SELECT user_id FROM informations WHERE user_id = ?");
$stmt->execute([$user_id]);
$exists = $stmt->fetchColumn();

if ($exists) {
    // Update
    $stmt = $conn->prepare("UPDATE informations SET bio = ?, phone = ?, visibility = ?, show_email = ?, job_title = ?, company = ?, education = ?, relationship_status = ?, website = ?, location = ?, hometown = ?, graduation_year = ?, birth_date = ?, gender = ? WHERE user_id = ?");
    $stmt->execute([
        $bio, $phone, $visibility, $show_email, $job_title, $company, $education, $relationship_status,
        $website, $location, $hometown, $graduation_year, $birth_date, $gender, $user_id
    ]);
} else {
    // Insert
    $stmt = $conn->prepare("INSERT INTO informations (user_id, bio, phone, visibility, show_email, job_title, company, education, relationship_status, website, location, hometown, graduation_year, birth_date, gender) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $user_id, $bio, $phone, $visibility, $show_email, $job_title, $company, $education, $relationship_status,
        $website, $location, $hometown, $graduation_year, $birth_date, $gender
    ]);
}

echo json_encode(['success' => true, 'message' => 'Profil mis à jour']);

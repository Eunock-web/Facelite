<?php
    require_once '../../Database/database.php';
    
header('Content-Type: application/json');
$input = file_get_contents("php://input");
$data = json_decode($input, true);

if(!$data){
    echo json_encode([
        "success" => false,
        "message" => "Données JSON invalides"
    ]);
    exit;
}

if(!isset($_SESSION['user_id'])){
    echo json_encode([
        "success" => false,
        "message" => "Utilisateur non connecté"
    ]);
    exit;
}

$req = $conn->prepare("SELECT * FROM users WHERE id = ?");
$req->execute([$_SESSION['user_id']]);
$users = $req->fetch(PDO::FETCH_ASSOC);

$infos = $stmt->fetch(PDO::FETCH_ASSOC);

if($users){
    echo json_encode([
        "success" => true,
        "users" => $users,
        "infos" => $infos
    ]);
    exit;
}else{
    echo json_encode([
        "success" => false,
        "message" => "Utilisateurs non trouvé",
    ]);
    exit;
}


?>
<?php
    require_once '../../Database/database.php';
    header('Content-Type: application/json');
    $data = json_decode($input, true);


    if(!isset($_SESSION['user_id'])){
        $retour = [
            'success' => false,
            'message' => 'Utilisateur non connecté'
        ];
        echo json_encode($retour);
        exit();
    }

    if(!$data){
        $retour = [
            'success' => false,
            'message' => 'Donnee non reçus'
        ];
        echo json_encode($retour);
        exit();
    }

    if(!$_SERVER['REQUEST_METHOD'] === 'POST') {
        $retour = [
            'success' => false,
            'message' => 'Methode non autorisée'
        ];
        echo json_encode($retour);
        exit();
    }
$user_id = $_SESSION['user_id'];
$commentaire = $data['commentaire'];

try {
    $req = $conn->prepare("INSERT INTO commentaire (user_id, commentaire) VALUES (?, ?)");
    $req->execute([$user_id, $commentaire]);
    $retour = [
        'success' => true,
        'message' => 'Commentaire ajouté'
    ];
    echo json_encode($retour);
    exit();
} catch (\Throwable $th) {
    $retour = [
        'success' => false,
        'message' => 'Erreur lors de l\'ajout du commentaire'
    ];
    echo json_encode($retour);
    exit();
}
    
?>
<?php
    require_once '../../Database/database.php';
    header('Content-Type: application/json');

    if(!isset($_SESSION['user_id'])){
        echo json_encode(['success'=>true, 'message'=>'Utilisateur non connecter']);
        exit();
    }else{
        try{
        $req = $conn->prepare("SELECT * FROM users WHERE is_validated = 1");
        $req->execute([$user_id]);
        $users = $req->fetch(PDO::FETCH_ASSOC);
            if($users){
                echo json_encode(['success'=>true, 'friends'=>$users]);
                exit();
            }else{
                echo json_encode(['success'=>false, 'message'=>'Utilisateurs non trouvés']);
                exit();
            }
        }catch(PDOException $e){
            echo json_encode(['success'=>false, 'message'=>'Erreur lors de la recuperation '. $e->getMessage()]);
            exit();
        }
    }
?>
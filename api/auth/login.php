<?php
    session_start();
    require_once("../../Database/database.php");
    
    header('Content-Type: application/json');
    $input = file_get_contents("php://input");

    $data = json_decode($input, true);
        if(isset($data['email'], $data['password'])){
            //Verification si le compte est confirmer   
                $req = $conn->prepare("SELECT * FROM users WHERE email=? AND is_validated = 1 ");
                $sql = $req->execute([$data['email']]);
                if($req->rowCount() === 0){ 
                    echo json_encode(["success"=>false, "message"=>"Compte inexistant ou compte invalide"]);
                    exit;
                }else{
                        $user = $req->fetch(PDO::FETCH_ASSOC);
                        // Vérification du mot de passe
                        if (password_verify($data['password'], $user['password'])) {
                            $_SESSION['user_id'] = $user['user_id'];
                            $_SESSION['firstname'] = $user['firstname'];
                            echo json_encode(["success"=>true, "message"=>"Connexion réussie"]);
                            exit;
                        } else {
                            echo json_encode(["success"=>false, "message"=>"Mot de passe incorrect"]);
                            exit;
                        }
                }
        }else{
            echo json_encode(["success"=>false, "message"=>"Les données n'ont pas été reçues"]);
            exit;
        }


?>
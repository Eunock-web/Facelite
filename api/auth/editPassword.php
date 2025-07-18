<?php
    header('Content-Type: application/json');
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);
    require_once("../../Database/database.php");

        if(!$data){
            echo json_encode(["statuts"=>false, "message"=>"Les données n\'ont pas pu être envoyées"]);
            exit;
        }
else{
            $email = $data['email'];
            $password = $data['password'];
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $req = $conn->prepare("SELECT * FROM users WHERE email=?");
            $req->execute([$email]);
            if($req->rowCount() === 0){ 
                echo json_encode(["success"=>false, "message"=>"Compte inexistant ou compte invalide"]);
                exit;
            }else{
                //Modification du mot de passe de l'utilisateur
                $req = $conn->prepare("UPDATE users SET password=? WHERE email=?");
                $sql = $req->execute([$hash, $email]);
                    if($sql){
                        echo json_encode(["success"=>true, "message"=>"Mot de passe modifié"]);
                        exit;
                    }else{
                        echo json_encode(["success"=>false, "message"=>"Mot de passe non modifié"]);
                        exit;
                    }

            }
        }

?>

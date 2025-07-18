<?php
    require_once '../../Database/database.php';
    require_once '../notifications/create.php';
    header('Content-Type: application/json');
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);
    session_start();

    if(!isset($_SESSION['user_id'])){
        echo json_encode(['success'=>false,'message'=>'Utilisateur non authentifie']);
        exit();
    }

    if(!$data){
        echo json_encode(['success'=>false,'message'=> 'Donnees non reçues']);
        exit();
    }else{
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            echo json_encode(['success'=>false,'message'=>'Methode non accepter']); 
            exit();          
        }else{
            try{
                $commentaire = $data['content'];
                $post_id = $data['postId'];
                $user_id = $_SESSION['user_id'];

                $req = $conn->prepare("INSERT INTO commentaires (post_id, user_id, content) VALUES (?,?,?)");
                $sql = $req->execute([$post_id, $user_id, $commentaire]);

                if(!$sql){
                    echo json_encode(['success'=>false,'message'=>'Insertion echoue']);
                    exit();
                }else{
                    // Créer une notification pour le propriétaire du post
                    $stmt = $conn->prepare("SELECT user_id FROM post WHERE post_id = ?");
                    $stmt->execute([$post_id]);
                    $post_owner = $stmt->fetch();
                    
                    if ($post_owner && $post_owner['user_id'] != $user_id) {
                        // Récupérer le nom de l'utilisateur qui commente
                        $stmt = $conn->prepare("SELECT firstname, lastname FROM users WHERE user_id = ?");
                        $stmt->execute([$user_id]);
                        $from_user = $stmt->fetch();
                        
                        if ($from_user) {
                            $from_user_name = $from_user['firstname'] . ' ' . $from_user['lastname'];
                            $content = getNotificationContent('comment', $from_user_name);
                            createNotification($post_owner['user_id'], $user_id, 'comment', $content, $post_id);
                        }
                    }
                    
                    echo json_encode(['success'=>true,'message'=>'Commentaire ajouter']);
                    exit();
                }
            }catch(PDOException $e){
                echo json_encode(['success'=>false,'message'=>'Erreur lors du traitement'. $e->getMessage()]);
            }
        }
    }

?>
<?php
session_start();
    $page = $_GET['page'] ?? 'home';
    $allowed_page = ['acceuil', 'ajoutAmis', 'photos', 'videos', 'update', 'demandesAmis', 'profil_edit', 'amis', 'notification', 'login', 'commentaire', 'messagerie', 'confirmPass', 'message','signup', 'confirm', 'mediaPost', 'editPassword', 'acceuil', 'insertEmail','profil'];
    if(!in_array($page, $allowed_page)){
        $page = 'notFound';
    }


    function getPagePath($page) {
        switch ($page) {
            case 'acceuil':        return 'vues/users/acceuil.php'; // ou accueil par défaut
            case 'login':          return 'vues/auth/login.php';
            case 'signup':         return 'vues/auth/signup.php';
            case 'confirm':        return 'vues/OTP/user/confirm.php';
            case 'confirmPass':    return 'vues/OTP/user/confirmEditPassword.php';
            case 'mediaPost':      return 'vues/posts/mediaPost.php';
            case 'profil':         return 'vues/users/profil.php';
            case 'editPassword':   return 'vues/auth/reset_email_form.php';
            case 'insertEmail':    return 'vues/auth/reset_email.php';
            case 'messagerie':     return 'vues/users/messagerie.php';
            case 'amis':           return 'vues/users/amis.php';
            case 'profil_edit':    return 'vues/users/profil_edit.php';
            case 'ajoutAmis':      return 'vues/users/friends.php';
            case 'demandesAmis':   return 'vues/users/demandesAmis.php';
            case 'notification':   return 'vues/users/notification.php';
            case 'update':         return 'vues/users/update.php';
            case 'photos':         return 'vues/users/photo.php';
            case 'videos':         return 'vues/users/video.php';
            case 'commentaire':    return 'vues/users/commentaire.php';
            default:               return 'vues/notFound.php';
        }
    }

    // Redirection si déjà connecté
    if (!isset($_SESSION['user_id']) && !in_array($page, ['login', 'signup', 'confirm','insertEmail', 'confirmPass'])) {
        $page = 'login'; // ou 'acceuil' selon ta logique
        header("Location:index.php?page=$page");
        exit();
    }else{
        if(isset($_SESSION['user_id']) && in_array($page, ['login', 'signup', 'home','insertEmail'])) {
            $page = 'acceuil'; // ou 'acceuil' selon ta logique
            header("Location:index.php?page=$page");
            exit();
        }
    }

    // Si AJAX (fetch), on ne renvoie que le contenu principal
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        include getPagePath($page);
    } else {
        // Sinon, on inclut le template complet (header, footer, etc.)
        include 'template/header.php';
        echo '<div id="content">';
        include getPagePath($page);
        echo '</div>';
        // include 'template/footer.php'; // si tu as un footer
    }
?>
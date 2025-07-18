<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facelite</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Configuration Tailwind pour éviter les problèmes de chargement
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#1877f2',
                        'primary-hover': '#166fe5'
                    }
                }
            }
        }
    </script>
    <!-- Ajout de Font Awesome pour les icônes -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/mediaPost.css">
    <link rel="stylesheet" href="assets/css/profil.css">
    <link rel="stylesheet" href="assets/css/messagerie.css">
    <script src="script.js" defer></script>
    <script src="assets/js/profil_edit.js" defer></script>
    <script src="assets/js/Posts/mediaPost.js"></script>
    <script src="assets/js/message.js"></script>
    <script src="assets/js/auth/profil.js"></script>
    <script>
        // Définir l'ID utilisateur connecté
        window.currentUserId = <?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'null'; ?>;
        
        // Fonction pour forcer le rechargement des styles
        window.forceReloadStyles = () => {
            document.body.offsetHeight;
            if (window.tailwind) {
                window.tailwind.refresh();
            }
        };
    </script>
</head>

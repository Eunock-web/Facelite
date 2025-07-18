// Fonction pour naviguer
async function navigateTo(page) {
    try {
        const response = await fetch(`app.php?page=${page}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        const data = await response.json();
        
        // Mettre à jour le contenu
        document.getElementById('content').innerHTML = data.content;
        
        // Gérer l'état d'authentification si nécessaire
        if (!data.isAuthenticated) {
            // Rediriger vers la page de connexion
            window.location.href = 'index.php?page=login';
        }
    } catch (error) {
        console.error('Erreur de navigation:', error);
    }
}
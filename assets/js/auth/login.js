
        // Script pour gérer l'affichage des erreurs
        document.addEventListener('DOMContentLoaded', function() {
            const errorMessage = document.getElementById('error-message');
            const errorText = document.getElementById('error-text');
            const closeError = document.getElementById('close-error');
            
            // Vérifier s'il y a une erreur dans l'URL
            const urlParams = new URLSearchParams(window.location.search);
            const error = urlParams.get('error');
            
            if (error) {
                errorText.textContent = decodeURIComponent(error);
                errorMessage.classList.remove('hidden');
                
                // Fermer automatiquement après 5 secondes
                setTimeout(() => {
                    errorMessage.classList.add('hidden');
                }, 5000);
            }
            
            // Fermer manuellement
            closeError.addEventListener('click', function() {
                errorMessage.classList.add('hidden');
            });
            
            // Toggle password visibility
            const togglePassword = document.getElementById('togglePassword');
            const password = document.getElementById('password');
            
            togglePassword.addEventListener('click', function() {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                this.innerHTML = type === 'password' ? 
                    '<i class="fas fa-eye text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 cursor-pointer text-lg"></i>' : 
                    '<i class="fas fa-eye-slash text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 cursor-pointer text-lg"></i>';
            });
            
        });

const loginForm = document.getElementById('login_Form');
        
loginForm.addEventListener('submit', (e) => {
    e.preventDefault();
    let formData = new FormData(loginForm);
    
    fetch("../../api/auth/login.php", {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify(Object.fromEntries(formData))
    })
    .then(response => {
        if (!response.ok) throw new Error("Erreur réseau");
        return response.json();
    })
    .then(data => {
        const errorMessage = document.getElementById('error-message');
        const errorText = document.getElementById('error-text');
        
        errorText.textContent = data.message;
        errorMessage.classList.remove('hidden');
        
        if (data.success) {
            errorMessage.style.backgroundColor = '#d1fae5'; // Vert clair pour succès
            setTimeout(() => {
                chargerPage("home");
            }, 2000);
        } else {
            errorMessage.style.backgroundColor = '#fee2e2'; // Rouge clair pour erreur
            setTimeout(() => {
                errorMessage.classList.add('hidden');
            }, 2000);
        }
    })
    .catch(err => {
        console.error("Erreur:", err);
        const errorMessage = document.getElementById('error-message');
        const errorText = document.getElementById('error-text');
        errorText.textContent = "Une erreur inattendue s'est produite";
        errorMessage.classList.remove('hidden');
        errorMessage.style.backgroundColor = '#fee2e2';
    });
});


const signup_link = document.getElementById('signup_link');

signup_link.addEventListener('click', (e) => {
    e.preventDefault();
    chargerPage("signup");
})

const forgotPasswordLink = document.getElementById('forgotPass');
forgotPasswordLink.addEventListener('click', (e) => {
    e.preventDefault();
    chargerPage("forgotPassword");
})

// Hook SPA navigation for demandesAmis
function afterPageLoad() {
    // Recharge la liste des demandes si on est sur la page demandesAmis
    if (window.location.search.includes('demandesAmis')) {
        if (typeof chargerDemandes === 'function') chargerDemandes();
        // Ou, si la page est rechargée dynamiquement, tu peux aussi forcer le script à être réexécuté
    }
    // Recharge la liste des amis si on est sur la page amis
    if (window.location.search.includes('amis') && typeof FriendsPage === 'function') {
        new FriendsPage();
    }
}

// Si tu as une fonction chargerPage, ajoute ce hook après chaque navigation
if (typeof window.chargerPage === 'function') {
    const oldChargerPage = window.chargerPage;
    window.chargerPage = function(page, ...args) {
        oldChargerPage(page, ...args);
        setTimeout(afterPageLoad, 300); // Laisse le temps au DOM de se mettre à jour
    };
}

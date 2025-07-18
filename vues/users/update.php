<header class="bg-gray-100 dark:bg-gray-800 shadow-sm sticky top-0 z-50">
    <div class="flex items-center justify-between px-4 h-14">
        <div class="flex items-center gap-2">
            <div class="w-10 h-10 flex items-center justify-center">
                <a href="?page=acceuil">
                    <img src="assets/images/facebook.png" alt="">
                </a>
            </div>
            <div class="relative hidden md:block">
                <div class="flex items-center bg-gray-100 dark:bg-gray-700 rounded-full pl-4 pr-12">
                    <i class="ri-search-line text-gray-500"></i>
                    <input type="text" placeholder="Rechercher sur Facebook" class="bg-transparent border-none outline-none py-2 px-2 text-sm w-60 dark:text-white dark:placeholder-gray-300">
                </div>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <button class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                <a href="?page=messagerie" class="spa-link">
                    <i class="ri-messenger-line text-xl"></i>
                </a>
            </button>
            <button class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                <a href="?page=amis" class="spa-link">
                    <i class="ri-group-line"></i>
                </a>
            </button>
            <button class="notification-btn w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                <a href="?page=notification" class="spa-link">
                    <i class="ri-notification-3-line text-xl"></i>
                </a>    
            </button>
            <button class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                <a href="?page=profil" class="spa-link">
                    <img src="https://readdy.ai/api/search-image?query=professional%20headshot%20of%20a%20young%20french%20man%20with%20friendly%20smile%2C%20natural%20lighting%2C%20high%20quality&width=40&height=40&seq=2&orientation=squarish" class="w-8 h-8 rounded-full object-cover">
                </a>
            </button>
        </div>
    </div>
</header>

<div class="flex bg-gray-100 dark:bg-gray-900 min-h-screen">
    <!-- Main content -->
    <main class="flex-1 p-6 flex justify-center items-center">
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow-md w-full max-w-md p-5 border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
            <div class="text-center mb-6 pb-4 border-b border-border-color">
                <h1 class="text-primary text-2xl font-semibold">Modifier votre compte</h1>
                <p class="text-[#606770] text-sm mt-1">Mettez à jour vos informations personnelles</p>
            </div>
            <form id="accountForm" class="space-y-5">
                <div class="relative">
                    <label for="email" class="block text-text-color text-sm font-medium mb-2">Adresse email</label>
                    <input type="email" id="email" name="email" 
                           class="w-full px-4 py-3 text-base border border-gray-300 dark:border-gray-600 rounded-md bg-[#f5f6f7] focus:border-primary focus:ring-2 focus:ring-blue-100 focus:bg-white outline-none transition-all" 
                           placeholder="Entrez votre nouvelle adresse email" required>
                    <div class="text-error text-sm mt-1 hidden" id="email-error">Veuillez entrer une adresse email valide</div>
                </div>
                <div class="relative">
                    <label for="password" class="block text-text-color text-sm font-medium mb-2">Nouveau mot de passe (laissez vide pour ne pas modifier)</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" 
                               class="w-full px-4 py-3 text-base border border-gray-300 dark:border-gray-600 rounded-md bg-[#f5f6f7] focus:border-primary focus:ring-2 focus:ring-blue-100 focus:bg-white outline-none transition-all">
                        <span class="absolute right-3 top-1/2 -translate-y-1/2 cursor-pointer text-[#65676b] hover:text-primary" id="togglePassword">👁️</span>
                    </div>
                    <div class="text-error text-sm mt-1 hidden" id="password-error">Le mot de passe doit contenir au moins 8 caractères</div>
                </div>
                <div class="relative">
                    <label for="confirmPassword" class="block text-text-color text-sm font-medium mb-2">Confirmer le nouveau mot de passe</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" 
                           class="w-full px-4 py-3 text-base border border-gray-300 dark:border-gray-600 rounded-md bg-[#f5f6f7] focus:border-primary focus:ring-2 focus:ring-blue-100 focus:bg-white outline-none transition-all">
                    <div class="text-error text-sm mt-1 hidden" id="confirm-error">Les mots de passe ne correspondent pas</div>
                </div>
                <div class="mb-5">
                    <button type="submit" class="w-full py-3 px-4 bg-primary text-white font-semibold rounded-md hover:bg-primary-hover transition-colors">
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
            <div class="mt-5 text-center text-sm">
                <a href="?page=profil" class="text-primary spa-link font-medium hover:underline">Retour au profil</a>
            </div>
        </div>
        <script>
            // Charger les informations existantes
            async function loadUserData() {
                try {
                    const response = await fetch('api/get_user_info.php');
                    const data = await response.json();
                    if (data.success) {
                        document.getElementById('email').value = data.email;
                    }
                } catch (error) {
                    if (typeof Utils !== 'undefined') Utils.showMessage('Erreur lors du chargement des données', false);
                }
            }
            // Initialiser le formulaire
            document.addEventListener('DOMContentLoaded', function() {
                // Charger les informations existantes
                loadUserData();

                // Toggle password visibility
                const togglePassword = document.getElementById('togglePassword');
                const password = document.getElementById('password');
                if (togglePassword && password) {
                    togglePassword.addEventListener('click', function() {
                        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                        password.setAttribute('type', type);
                        this.textContent = type === 'password' ? '👁️' : '🔒';
                    });
                }

                // Gestion de la soumission du formulaire
                document.getElementById('accountForm').addEventListener('submit', async (e) => {
                    e.preventDefault();
                    // Récupérer les données du formulaire
                    const formData = {
                        email: document.getElementById('email').value,
                        password: document.getElementById('password').value,
                        confirmPassword: document.getElementById('confirmPassword').value
                    };
                    // Validation client
                    let isValid = true;
                    // Reset des messages d'erreur
                    document.querySelectorAll('[id$=\"-error\"]').forEach(el => el.classList.add('hidden'));
                    // Validation email
                    if (!formData.email.includes('@') || !formData.email.includes('.')) {
                        document.getElementById('email-error').classList.remove('hidden');
                        isValid = false;
                    }
                    // Validation mot de passe
                    if (formData.password) {
                        if (formData.password.length < 8) {
                            document.getElementById('password-error').classList.remove('hidden');
                            isValid = false;
                        }
                        if (formData.password !== formData.confirmPassword) {
                            document.getElementById('confirm-error').classList.remove('hidden');
                            isValid = false;
                        }
                    }
                    if (!isValid) return;
                    try {
                        console.log('Envoi AJAX vers api/update.php', formData);
                        const response = await fetch("api/update.php", {
                            method: "POST",
                            headers: { "Content-Type": "application/json" },
                            body: JSON.stringify(formData)
                        });
                        const data = await (typeof Utils !== 'undefined' ? Utils.handleFetchError(response) : response.json());
                        console.log('Réponse API update.php:', data);
                        if (data.success) {
                            if (typeof Utils !== 'undefined') Utils.showMessage(data.message, true);
                            setTimeout(() => {
                                console.log('Redirection SPA, chargerPage:', typeof window.chargerPage);
                                if (typeof window.chargerPage === 'function') {
                                    window.chargerPage('profil');
                                } else {
                                    window.location.href = '?page=profil';
                                }
                            }, 1500); // Laisse le temps au message de succès d’apparaître
                        } else {
                            if (typeof Utils !== 'undefined') Utils.showMessage(data.message, false);
                            if (data.errors) {
                                data.errors.forEach(error => {
                                    if (error.includes('email')) {
                                        document.getElementById('email-error').classList.remove('hidden');
                                    } else if (error.includes('mot de passe')) {
                                        document.getElementById('password-error').classList.remove('hidden');
                                    } else if (error.includes('correspondent')) {
                                        document.getElementById('confirm-error').classList.remove('hidden');
                                    }
                                });
                            }
                        }
                    } catch (err) {
                        console.error('Erreur AJAX:', err);
                        if (typeof Utils !== 'undefined') Utils.showMessage(err.message, false);
                    }
                });
            });
        </script>
    </main>
</div>

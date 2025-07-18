<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier votre compte - FaceLite</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/mediaPost.css">
    <link rel="stylesheet" href="../assets/css/profil.css">
    <link rel="stylesheet" href="../assets/css/messagerie.css">
    <script src="../script.js" defer></script>
    <script>
        // Configuration Tailwind
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#1877f2',
                        'primary-hover': '#166fe5',
                        secondary: '#f0f2f5',
                        'text-color': '#1c1e21',
                        'border-color': '#dddfe2',
                        success: '#42b72a',
                        error: '#ff4242',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-white dark:bg-gray-900">
    <div class="bg-secondary flex justify-center items-center min-h-screen p-5">
        <div class="bg-white rounded-lg shadow-md w-full max-w-md p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
            <div class="text-center mb-6 pb-4 border-b border-border-color">
                <h1 class="text-primary text-2xl font-semibold">Modifier votre compte</h1>
                <p class="text-[#606770] text-sm mt-1">Mettez à jour vos informations personnelles</p>
            </div>
            
            <form id="accountForm" class="space-y-5">
                <div class="relative">
                    <label for="email" class="block text-text-color text-sm font-medium mb-2">Adresse email</label>
                    <input type="email" id="email" name="email" 
                           class="w-full px-4 py-3 text-base border border-border-color rounded-md bg-[#f5f6f7] focus:border-primary focus:ring-2 focus:ring-blue-100 focus:bg-white outline-none transition-all" 
                           placeholder="Entrez votre nouvelle adresse email" required>
                    <div class="text-error text-sm mt-1 hidden" id="email-error">Veuillez entrer une adresse email valide</div>
                </div>
                
                <div class="relative">
                    <label for="password" class="block text-text-color text-sm font-medium mb-2">Nouveau mot de passe (laissez vide pour ne pas modifier)</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" 
                               class="w-full px-4 py-3 text-base border border-border-color rounded-md bg-[#f5f6f7] focus:border-primary focus:ring-2 focus:ring-blue-100 focus:bg-white outline-none transition-all">
                        <span class="absolute right-3 top-1/2 -translate-y-1/2 cursor-pointer text-[#65676b] hover:text-primary" id="togglePassword">👁️</span>
                    </div>
                    <div class="text-error text-sm mt-1 hidden" id="password-error">Le mot de passe doit contenir au moins 8 caractères</div>
                </div>
                
                <div class="relative">
                    <label for="confirmPassword" class="block text-text-color text-sm font-medium mb-2">Confirmer le nouveau mot de passe</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" 
                           class="w-full px-4 py-3 text-base border border-border-color rounded-md bg-[#f5f6f7] focus:border-primary focus:ring-2 focus:ring-blue-100 focus:bg-white outline-none transition-all">
                    <div class="text-error text-sm mt-1 hidden" id="confirm-error">Les mots de passe ne correspondent pas</div>
                </div>
                
                <div class="mb-5">
                    <button type="submit" class="w-full py-3 px-4 bg-primary text-white font-semibold rounded-md hover:bg-primary-hover transition-colors">
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
            
            <div class="mt-5 text-center text-sm">
                <a href="profil.php" class="text-primary font-medium hover:underline">Retour au profil</a>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirmPassword');
        
        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            confirmPassword.setAttribute('type', type);
            this.textContent = type === 'password' ? '👁️' : '🔒';
        });

        // Charger les informations existantes
        async function loadUserData() {
            try {
                const response = await fetch('api/get_user_info.php');
                const data = await response.json();
                if (data.success) {
                    document.getElementById('email').value = data.email;
                }
            } catch (error) {
                console.error('Erreur lors du chargement des données:', error);
                Utils.showMessage('Erreur lors du chargement des données', false);
            }
        }

        // Initialiser le formulaire
        document.addEventListener('DOMContentLoaded', loadUserData);

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
            document.querySelectorAll('[id$="-error"]').forEach(el => el.classList.add('hidden'));

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
                const response = await fetch("api/update.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(formData)
                });

                const data = await Utils.handleFetchError(response);

                if (data.success) {
                    Utils.showMessage(data.message, true);
                    // Redirection vers le profil après succès
                    setTimeout(() => window.location.href = 'profil.php', 2000);
                } else {
                    Utils.showMessage(data.message, false);
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
                Utils.showMessage(err.message, false);
            }
        });
    </script>
</body>
</html>

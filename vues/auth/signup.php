
<?php
            function generateCsrfToken(): string{
        // Vérifie si la session est démarrée
        if (session_status() === PHP_SESSION_NONE) {    
            session_start();
        }

        // Génère un token aléatoire sécurisé
        $token = bin2hex(random_bytes(32));

        // Stocke le token en session
        $_SESSION['csrf_token'] = $token;
        $_SESSION['csrf_token_time'] = time();

        return $token;
    }    
    $csrf_token = generateCsrfToken();
    ?>
    <!-- Error message div -->
     <div class="bg-gray-100 dark:bg-gray-900 min-h-screen flex items-center justify-center p-4 transition-colors duration-300">
    <div id="error-message" class="fixed top-20 right-4 max-w-xs w-full bg-red-100 dark:bg-red-900 border-l-4 border-red-500 dark:border-red-700 text-red-700 dark:text-red-100 p-4 rounded shadow-lg hidden transition-all duration-300 z-50">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-500 dark:text-red-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p id="error-text" class="text-sm font-medium"></p>
            </div>
            <div class="ml-auto pl-3">
                <button id="close-error" class="text-red-500 dark:text-red-300 hover:text-red-700 dark:hover:text-red-100">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl overflow-hidden w-full max-w-4xl transition-colors duration-300">        
        <div class="flex flex-col lg:flex-row">
            <!-- Image div - hidden on small screens, visible on large screens -->
            <div class="hidden lg:block lg:w-1/2 bg-facebook-blue dark:bg-blue-900 p-8 flex items-center justify-center transition-colors duration-300">
                <img src="assets/images/facebook.png" alt="Facebook" class="max-w-xs">
            </div>
            
            <!-- Form section -->
            <div class="w-full lg:w-1/2 p-8">
                <h1 class="text-3xl font-bold text-center text-facebook-blue dark:text-blue-400 mb-6 transition-colors duration-300">FaceLite</h1>
                

                
                <form method="post" class="space-y-4" id="signup_form">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="firstname" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                <i class="fas fa-user mr-1"></i> Nom
                            </label>
                            <div class="relative">
                                <input type="text" id="firstname" name="firstname" required placeholder="Ex: YAGAMI"
                                       class="w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-facebook-blue focus:border-facebook-blue dark:bg-gray-700 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="lastname" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                <i class="fas fa-user mr-1"></i> Prénom
                            </label>
                            <div class="relative">
                                <input type="text" id="lastname" name="lastname" required placeholder="Ex: Light"
                                       class="w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-facebook-blue focus:border-facebook-blue dark:bg-gray-700 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            <i class="fas fa-envelope mr-1"></i> E-mail
                        </label>
                        <div class="relative">
                            <input type="email" id="email" name="email" required placeholder="erwinmith@gmail.com"
                                   class="w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-facebook-blue focus:border-facebook-blue dark:bg-gray-700 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="birthday" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            <i class="fas fa-calendar-alt mr-1"></i> Date de naissance
                        </label>
                        <div class="relative">
                            <input type="date" id="birthday" name="birthday" required
                                   class="w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-facebook-blue focus:border-facebook-blue dark:bg-gray-700 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-calendar-alt text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="genre" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            <i class="fas fa-venus-mars mr-1"></i> Genre
                        </label>
                        <div class="relative">
                            <select name="genre" id="genre"
                                    class="w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-facebook-blue focus:border-facebook-blue dark:bg-gray-700 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="Masculin">Masculin</option>
                                <option value="Feminin">Féminin</option>
                            </select>
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-venus-mars text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            <i class="fas fa-lock mr-1"></i> Mot de passe
                        </label>
                        <div class="relative">
                            <input type="password" id="password" name="password" required
                                   class="w-full pl-10 pr-10 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-facebook-blue focus:border-facebook-blue dark:bg-gray-700 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i class="fas fa-eye text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 cursor-pointer"></i>
                            </button>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" name="register"
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-facebook-blue hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-facebook-blue dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-500 transition-colors duration-300" id="signup_form">
                            <i class="fas fa-user-plus mr-2"></i> Inscription
                        </button>
                        <p class="text-center text-sm text-gray-500 dark:text-gray-400 mt-2">Vous avez déja un compte ? <a href="?page=login" class="text-facebook-blue dark:text-blue-400 hover:underline text-blue-600 text-duration-300 spa-link">Se connecter</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>


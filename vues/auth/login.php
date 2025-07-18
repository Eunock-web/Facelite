
        <!-- Error message div -->
         <div class="bg-gray-100 dark:bg-gray-900 min-h-screen flex items-center justify-center p-4 transition-colors duration-300">
        <div id="error-message" class="fixed top-20 right-4 max-w-xs w-full bg-red-100 dark:bg-red-900 border-l-4 border-red-500 dark:border-red-700 text-red-700 dark:text-red-100 p-4 rounded shadow-lg hidden transition-all duration-300 z-50 ">
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

        <div class="bg-white rounded-lg shadow-xl overflow-hidden w-full max-w-4xl transition-colors duration-300">        
            <div class="flex flex-col lg:flex-row h-full">
                <!-- Image div - hidden on small screens, visible on large screens -->
                <div class="hidden lg:block lg:w-1/2 bg-facebook-blue dark:bg-blue-900 p-8 transition-colors duration-300 flex items-center justify-center">
                    <div class="flex flex-col items-center justify-center h-full w-full">
                        <img src="assets/images/facebook.png" alt="Facebook" class="w-full max-w-xs object-contain">
                    </div>
                </div>
                
                <!-- Form section - Agrandi avec plus d'espace -->
                <div class="w-full lg:w-1/2 p-10 dark:bg-gray-800">
                    <h1 class="text-3xl font-bold text-center text-facebook-blue dark:text-blue-400 mb-10 transition-colors duration-300">FaceLite</h1>
                    
                    <form method="post" class="space-y-8" id="login_Form">
                        <div class="space-y-6">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 transition-colors duration-300">
                                    <i class="fas fa-envelope mr-1"></i> E-mail
                                </label>
                                <div class="relative">
                                    <input type="email" id="email" name="email" required 
                                        placeholder="erwinmith@gmail.com"
                                        class="w-full pl-12 pr-4 py-3 text-lg border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-facebook-blue focus:border-facebook-blue dark:bg-gray-700 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-colors duration-300">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-envelope text-gray-400 text-lg"></i>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 transition-colors duration-300">
                                    <i class="fas fa-lock mr-1"></i> Mot de passe
                                </label>
                                <div class="relative">
                                    <input type="password" id="password" name="password" required
                                        class="w-full pl-12 pr-12 py-3 text-lg border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-facebook-blue focus:border-facebook-blue dark:bg-gray-700 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-colors duration-300">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-lock text-gray-400 text-lg"></i>
                                    </div>
                                    <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-4 flex items-center">
                                        <i class="fas fa-eye text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 cursor-pointer text-lg"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <button type="submit" name="connexion"
                                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-lg font-medium text-white bg-facebook-blue hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-facebook-blue dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-500 transition-colors duration-300">
                                Connexion
                            </button>
                            <p class="text-center text-sm text-gray-500 dark:text-gray-400">
                                Vous n'avez pas de compte ? <a href="?page=signup"  class="text-facebook-blue dark:text-blue-400 hover:underline text-blue-600 text-duration-300 spa-link">S'inscrire</a>
                            </p>
                            <p class="text-center text-sm text-gray-500 dark:text-gray-400">
                                <a href="?page=insertEmail"  class="text-facebook-blue dark:text-blue-400 hover:underline text-blue-600 text-duration-300 spa-link">
                                    <i class="fas fa-key mr-1"></i> Mot de passe oublié ?
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
                <i class="ri-messenger-line text-xl"></i>
            </button>
            <button class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                <i class="ri-notification-3-line text-xl"></i>
            </button>
            <button class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                <img src="https://readdy.ai/api/search-image?query=professional%20headshot%20of%20a%20young%20french%20man%20with%20friendly%20smile%2C%20natural%20lighting%2C%20high%20quality&width=40&height=40&seq=2&orientation=squarish" class="w-8 h-8 rounded-full object-cover">
            </button>
        </div>
    </div>
</header>

<div class="min-h-screen flex items-center justify-center p-4 bg-gray-100 dark:bg-gray-900">
    <div class="w-full max-w-2xl bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl text-center font-bold text-gray-800 dark:text-white w-full">Créer une publication</h1>
        </div>

        <!-- Post Form -->
        <div class="mb-6">
            <!-- User Info -->
            <div class="flex items-center mb-4">
                <img src="https://via.placeholder.com/40" alt="Profile" class="w-10 h-10 rounded-full mr-3">
                <div>
                    <p class="font-semibold text-gray-800 dark:text-white"><?php echo $_SESSION['firstname'] ?></p>
                </div>
            </div>

            <!-- Preview Area -->
            <div id="preview-container" class="hidden mb-4 rounded-lg overflow-hidden bg-gray-50 dark:bg-gray-700">
                <!-- Contenu dynamique ajouté par JavaScript -->
            </div>

            <!-- Description Field -->
            <input 
                type="text" 
                name="description" 
                id="description" 
                placeholder="Ajouter une description (optionnel)" 
                class="w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 placeholder-gray-500 dark:placeholder-gray-400 text-gray-800 dark:text-white"
            />

            <!-- Options -->
            <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-3 mb-4 bg-gray-50 dark:bg-gray-700">
                <p class="text-lg text-center font-medium mb-2 text-gray-800 dark:text-white">Ajouter à votre publication</p>
                <div class="flex justify-between">
                    <!-- Bouton pour image -->
                    <label class="flex items-center cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 rounded-lg p-2 transition-colors">
                        <input type="file" id="image-upload" accept="image/*" class="hidden">
                        <div class="flex items-center">
                            <div class="bg-blue-100 dark:bg-blue-900 p-2 rounded-full text-blue-500 dark:text-blue-300 mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <span class="text-lg text-gray-800 dark:text-white">Photo</span>
                        </div>
                    </label>

                    <!-- Bouton pour vidéo -->
                    <label class="flex items-center cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 rounded-lg p-2 transition-colors">
                        <input type="file" id="video-upload" accept="video/*" class="hidden">
                        <div class="flex items-center">
                            <div class="bg-green-100 dark:bg-green-900 p-2 rounded-full text-green-500 dark:text-green-300 mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v8a2 2 0 01-2 2h-2a2 2 0 01-2-2V6z" />
                                </svg>
                            </div>
                            <span class="text-lg text-gray-800 dark:text-white">Vidéo</span>
                        </div>
                    </label>
                </div>
            </div> 

            <!-- Error Message -->
            <div id="error-message" class="hidden mb-4 px-4 py-2 rounded-md text-sm font-medium bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200 transition-all duration-300">
                <span id="error-text"></span>
            </div>

            <!-- Post Button -->
            <button id="post-button" disabled class="w-full bg-blue-600 dark:bg-blue-700 hover:bg-blue-700 dark:hover:bg-blue-800 text-white font-semibold py-2 px-4 rounded-md disabled:opacity-50 disabled:cursor-not-allowed flex justify-center items-center transition-colors">
                <span id="button-text">Publier</span>
                <svg id="loading-spinner" class="hidden h-5 w-5 ml-2 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </button>
        </div>

        <!-- Footer Info -->
        <div class="text-xs text-gray-500 dark:text-gray-400 text-center">
            <p>En publiant, vous acceptez nos Conditions d'utilisation et notre Politique de confidentialité.</p>
        </div>
    </div>
</div>
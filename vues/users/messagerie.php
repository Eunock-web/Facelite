<body class="bg-gray-200 dark:bg-gray-900 min-h-screen">
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

    <main class="main-container pt-2 ">
        <!-- Conteneur principal -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg h-full flex flex-col md:flex-row">
            <!-- Liste des conversations (visible par défaut sur desktop, cachée sur mobile) -->
            <div class="conversation-list w-full md:w-80 border-r border-gray-200 dark:border-gray-700 flex flex-col md:block active md:active">
                <!-- En-tête de la liste -->
                <div class="p-3 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                    <h2 class="font-semibold text-gray-800 dark:text-white">Messages</h2>
                    <button class="p-1 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors md:hidden" id="toggle-message-area">
                        <i class="ri-arrow-right-line text-gray-600 dark:text-gray-300"></i>
                    </button>
                </div>
                
                <!-- Barre de recherche -->
                <div class="p-3 border-b border-gray-200 dark:border-gray-700">
                    <div class="relative">
                        <i class="ri-search-line absolute left-3 top-2.5 text-gray-500 dark:text-gray-400"></i>
                        <input type="text" placeholder="Rechercher des messages" class="w-full bg-gray-100 dark:bg-gray-700 border-none rounded-full pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 text-gray-800 dark:text-white placeholder-gray-500 dark:placeholder-gray-400">
                    </div>
                </div>
                
                <!-- Liste des conversations -->
                <div class="flex-1 overflow-y-auto" id="conversations-list">
                    <!-- Les conversations seront chargées dynamiquement ici -->
                    <div class="p-4 text-center text-gray-500 dark:text-gray-400">
                        <i class="ri-loader-4-line animate-spin text-2xl mb-2"></i>
                        <p>Chargement des conversations...</p>
                    </div>
                </div>
            </div>
            
            <!-- Zone de messagerie (cachée par défaut sur mobile) -->
            <div class="message-area flex-1 flex flex-col hidden md:flex" id="message-area">
                <!-- En-tête de la conversation -->
                <div class="border-b border-gray-200 dark:border-gray-700 p-3 flex items-center" id="conversation-header">
                    <button class="p-1 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors mr-2 md:hidden" id="toggle-conversation-list">
                        <i class="ri-arrow-left-line text-gray-600 dark:text-gray-300"></i>
                    </button>
                    <div class="flex-1 flex items-center">
                        <img src="assets/images/default-avatar.jpg" alt="Profil" class="w-10 h-10 rounded-full mr-3" id="conversation-avatar">
                        <div>
                            <h2 class="font-semibold text-gray-800 dark:text-white" id="conversation-name">Sélectionnez une conversation</h2>
                            <p class="text-xs text-gray-500 dark:text-gray-400" id="conversation-status">En ligne</p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                            <i class="ri-phone-line text-gray-600 dark:text-gray-300"></i>
                        </button>
                        <button class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                            <i class="ri-vidicon-line text-gray-600 dark:text-gray-300"></i>
                        </button>
                        <button class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                            <i class="ri-information-line text-gray-600 dark:text-gray-300"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Messages -->
                <div class="flex-1 p-4 overflow-y-auto bg-gray-50 dark:bg-gray-700/30" id="messages-container">
                    <!-- Message d'accueil initial -->
                    <div id="welcome-message" class="flex items-center justify-center h-full">
                        <div class="text-center text-gray-500 dark:text-gray-400">
                            <i class="ri-message-3-line text-4xl mb-2"></i>
                            <p>Sélectionnez une conversation pour commencer</p>
                        </div>
                    </div>
                </div>
                
                <!-- Zone de saisie -->
                <div class="border-t border-gray-200 dark:border-gray-700 p-3 bg-white dark:bg-gray-800">
                    <div class="flex items-center">
                        <button class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors mr-2">
                            <i class="ri-emotion-line text-gray-600 dark:text-gray-300"></i>
                        </button>
                        <input type="text" placeholder="Écrire un message..." class="flex-1 bg-gray-100 dark:bg-gray-700 border-none rounded-full py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 text-gray-800 dark:text-white" id="message-input" disabled>
                        <button class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors ml-2" id="send-message">
                            <i class="ri-send-plane-2-fill text-blue-600 dark:text-blue-400"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
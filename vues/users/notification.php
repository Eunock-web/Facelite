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

    <div class="flex max-w-6xl mx-auto pt-4 px-2">
        <!-- Sidebar gauche -->
        <aside class="sidebar w-64 pr-4 hidden md:block">
            <div class="space-y-2">
                <a href="?page=profil" class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">
                    <div class="w-8 h-8 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                        <i class="ri-user-line"></i>
                    </div>
                    <span class="dark:text-white">Votre profil</span>
                </a>
                <a href="?page=ajoutAmis" class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">
                    <div class="w-8 h-8 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                        <i class="ri-group-line"></i>
                    </div>
                    <span class="dark:text-white">Ajouter Amis</span>
                </a>
                <a href="?page=messagerie" class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">
                    <div class="w-8 h-8 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                        <i class="ri-chat-3-line"></i>
                    </div>
                    <span class="dark:text-white">Messagerie</span>
                </a>
                <a href="?page=notification" class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">
                    <div class="w-8 h-8 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                        <i class="ri-notification-3-line"></i>
                    </div>
                    <span class="dark:text-white">Notifications</span>
                </a>
            </div>
        </aside>

        <!-- Contenu principal -->
        <main class="flex-1">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                <!-- En-tête des notifications -->
                <div class="border-b border-gray-200 dark:border-gray-700 p-4">
                    <h1 class="text-xl font-bold text-gray-800 dark:text-white">Notifications</h1>
                    <div class="flex mt-3">
                        <button class="px-4 py-2 font-medium text-blue-600 dark:text-blue-400 border-b-2 border-blue-600 dark:border-blue-400">
                            Toutes
                        </button>
                        <button class="px-4 py-2 font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                            Non lues
                        </button>
                    </div>
                </div>

                <!-- Liste des notifications -->
                <div id="notifications-container" class="divide-y divide-gray-200 dark:divide-gray-700">
                    <!-- Les notifications seront chargées ici dynamiquement -->
                </div>

                <!-- Voir plus -->
                <div class="p-4 text-center border-t border-gray-200 dark:border-gray-700">
                    <button id="load-more-btn" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-white font-medium rounded-md transition-colors">
                        Voir plus de notifications
                    </button>
                </div>
            </div>
        </main>
    </div>
</body>
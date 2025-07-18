<body class="bg-[#f0f2f5] dark:bg-gray-800">
    <!-- Header identique -->
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
            <div class="space-y-1">
                <a href="?page=profil" class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">
                    <div class="w-8 h-8 rounded-full bg-gray-300 dark:bg-gray-700 flex items-center justify-center text-primary">
                        <i class="ri-user-line"></i>
                    </div>
                    <span class="text-gray-800 dark:text-white">Votre profil</span>
                </a>
                <a href="?page=ajoutAmis" class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">
                    <div class="w-8 h-8 rounded-full bg-gray-300 dark:bg-gray-700 flex items-center justify-center text-primary">
                        <i class="ri-group-line"></i>
                    </div>
                    <span class="text-gray-800 dark:text-white">Ajouter amis</span>
                </a>
                <a href="?page=messagerie" class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">
                    <div class="w-8 h-8 rounded-full bg-gray-300 dark:bg-gray-700 flex items-center justify-center text-primary">
                        <i class="ri-chat-3-line"></i>
                    </div>
                    <span class="text-gray-800 dark:text-white">Messagerie</span>
                </a>
                <a href="?page=notifications" class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">
                    <div class="w-8 h-8 rounded-full bg-gray-300 dark:bg-gray-700 flex items-center justify-center text-primary">
                        <i class="ri-notification-3-line"></i>
                    </div>
                    <span class="text-gray-800 dark:text-white">Notifications</span>
                </a>
            </div>
        </aside>

        <!-- Contenu principal - Commentaires -->
        <main class="flex-1">
            <!-- Conteneur pour le post -->
            <div id="post-container" class="bg-white dark:bg-[#242526] rounded-lg shadow mb-4">
                <!-- Le contenu du post sera injecté ici -->
            </div>

            <!-- Conteneur pour les commentaires -->
            <div class="bg-white dark:bg-[#242526] rounded-lg shadow">
                <!-- Zone de commentaire -->
                <div class="p-4 border-b dark:border-[#3e4042]">
                    <div class="flex items-center gap-2 mb-3">
                        <img src="assets/images/facebook.png" class="w-8 h-8 rounded-full object-cover">
                        <div class="flex-1">
                            <input type="text" name="commentaire" id="comment-input" placeholder="Écrire un commentaire..." class="w-full bg-[#f0f2f5] dark:bg-[#3a3b3c] rounded-full px-4 py-2 text-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary">
                        </div>
                        <button id="comment-submit" class="px-4 py-2 bg-primary text-white rounded-full hover:bg-primary/90">Commenter</button>
                    </div>
                </div>

                <!-- Section des commentaires -->
                <div id="comments-section" class="divide-y dark:divide-[#3e4042]">
                    <!-- Les commentaires seront injectés ici -->
                </div>
            </div>
        </main>
    </div>
</body>
</html>
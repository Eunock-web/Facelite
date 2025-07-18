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
                        <i class="ri-user-add-line"></i>
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
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-4">
                <!-- En-tête -->
                <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Mes Amis</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Connectez-vous avec vos amis</p>
                </div>

                <!-- Barre de recherche -->
                <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="relative">
                        <i class="ri-search-line absolute left-3 top-2.5 text-gray-500 dark:text-gray-400"></i>
                        <input type="text" id="search-friends" placeholder="Rechercher parmi vos amis..." class="w-full bg-gray-100 dark:bg-gray-700 border-none rounded-full pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 text-gray-800 dark:text-white placeholder-gray-500 dark:placeholder-gray-400">
                    </div>
                </div>

                <!-- Liste des amis -->
                <div class="p-4">
                    <div id="friends-list" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- Les amis seront chargés ici dynamiquement -->
                        <div class="p-4 text-center text-gray-500 dark:text-gray-400">
                            <i class="ri-loader-4-line animate-spin text-2xl mb-2"></i>
                            <p>Chargement des amis...</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Classe pour gérer la page des amis
        class FriendsPage {
            constructor() {
                this.init();
            }

            init() {
                this.loadFriends();
                this.setupEventListeners();
            }

            // Charger la liste des amis
            async loadFriends() {
                try {
                    const response = await fetch('api/profil/friends.php');
                    const data = await response.json();

                    if (data.success) {
                        this.renderFriends(data.friends);
                    } else {
                        this.showError('Erreur lors du chargement des amis');
                    }
                } catch (error) {
                    console.error('Erreur:', error);
                    this.showError('Erreur de connexion');
                }
            }

            // Afficher les amis
            renderFriends(friends) {
                const container = document.getElementById('friends-list');
                
                if (friends.length === 0) {
                    container.innerHTML = `
                        <div class="col-span-full p-8 text-center text-gray-500 dark:text-gray-400">
                            <i class="ri-user-line text-4xl mb-4"></i>
                            <p class="text-lg font-medium mb-2">Aucun ami</p>
                            <p>Ajoutez des amis pour commencer à discuter</p>
                        </div>
                    `;
                    return;
                }

                container.innerHTML = friends.map(friend => `
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex flex-col items-center text-center">
                            <img src="${friend.profil || 'assets/images/default-avatar.jpg'}" alt="${friend.firstname} ${friend.lastname}" class="w-20 h-20 rounded-full mb-3 object-cover">
                            <h3 class="font-semibold text-gray-800 dark:text-white mb-1">${friend.firstname} ${friend.lastname}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">Ami</p>
                            <div class="flex gap-2 w-full">
                                <button class="message-friend-btn flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md text-sm transition-colors" data-user-id="${friend.user_id}" data-user-name="${friend.firstname} ${friend.lastname}">
                                    <i class="ri-message-3-line mr-1"></i> Message
                                </button>
                                <a href="?page=profil&user_id=${friend.user_id}" class="flex-1 bg-gray-200 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-800 dark:text-white font-medium py-2 px-4 rounded-md text-sm transition-colors">
                                    <i class="ri-user-line mr-1"></i> Profil
                                </a>
                            </div>
                        </div>
                    </div>
                `).join('');

                // Ajouter les event listeners
                this.setupFriendListeners();
            }

            // Configurer les listeners pour les boutons d'amis
            setupFriendListeners() {
                document.querySelectorAll('.message-friend-btn').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const userId = btn.dataset.userId;
                        const userName = btn.dataset.userName;
                        this.startConversation(userId, userName);
                    });
                });
            }

            // Démarrer une conversation
            async startConversation(otherUserId, userName) {
                try {
                    const response = await fetch('api/message/conversations.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            other_user_id: otherUserId
                        })
                    });
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        // Rediriger vers la messagerie avec la conversation
                        window.location.href = `?page=messagerie&conversation_id=${data.conversation.id}`;
                    } else {
                        this.showError(data.message || 'Erreur lors de la création de la conversation');
                    }
                } catch (error) {
                    console.error('Erreur:', error);
                    this.showError('Erreur de connexion');
                }
            }

            // Configurer les event listeners
            setupEventListeners() {
                // Recherche d'amis
                const searchInput = document.getElementById('search-friends');
                if (searchInput) {
                    searchInput.addEventListener('input', (e) => {
                        this.filterFriends(e.target.value);
                    });
                }
            }

            // Filtrer les amis
            filterFriends(searchTerm) {
                const friendCards = document.querySelectorAll('#friends-list > div');
                const searchLower = searchTerm.toLowerCase();

                friendCards.forEach(card => {
                    const name = card.querySelector('h3').textContent.toLowerCase();
                    if (name.includes(searchLower)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            }

            // Afficher une erreur
            showError(message) {
                // Utiliser la fonction Utils.showMessage si disponible
                if (typeof Utils !== 'undefined' && Utils.showMessage) {
                    Utils.showMessage(message, false);
                } else {
                    alert(message);
                }
            }
        }

        // Initialiser la page des amis quand le DOM est chargé
        document.addEventListener('DOMContentLoaded', () => {
            new FriendsPage();
        });
    </script>
</body>
</html> 
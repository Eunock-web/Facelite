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
                <!-- <a href="?page=amis" class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">
                    <div class="w-8 h-8 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                        <i class="ri-group-line"></i>
                    </div>
                    <span class="dark:text-white">Amis</span>
                </a> -->
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
                <!-- <a href="#" class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">
                    <div class="w-8 h-8 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                        <i class="ri-store-2-line"></i>
                    </div>
                    <span class="dark:text-white">Marketplace</span>
                </a> -->
            </div>
            
            <!-- <div class="mt-6">
                <h3 class="text-gray-500 dark:text-gray-400 font-semibold px-2 mb-2">Vos raccourcis</h3>
                <a href="#" class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">
                    <img src="https://picsum.photos/200" class="w-8 h-8 rounded-md object-cover">
                    <span class="dark:text-white">Groupe Dev Web</span>
                </a>
                <a href="#" class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">
                    <img src="https://picsum.photos/201" class="w-8 h-8 rounded-md object-cover">
                    <span class="dark:text-white">Communauté React</span>
                </a>
            </div> -->
        </aside>

        <!-- Contenu principal -->
        <main class="flex-1 max-w-2xl mx-2">
            <!-- Stories -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-4 p-4">
                <div class="flex space-x-2 overflow-x-auto pb-2 scrollbar-hide">
                    <!-- Votre story -->
                    <div class="flex flex-col items-center">
                        <div class="relative">
                            <div class="w-32 h-48 rounded-lg bg-gray-200 dark:bg-gray-700 overflow-hidden">
                                <img src="https://readdy.ai/api/search-image?query=professional%20headshot%20of%20a%20young%20french%20man%20with%20friendly%20smile%2C%20natural%20lighting%2C%20high%20quality&width=256&height=384&seq=2&orientation=squarish" class="w-full h-full object-cover">
                            </div>
                            <div class="absolute -bottom-6 left-1/2 transform -translate-x-1/2">
                                <div class="w-12 h-12 rounded-full border-4 border-white dark:border-gray-800 bg-white dark:bg-gray-800 flex items-center justify-center">
                                    <i class="ri-add-circle-fill text-blue-500 text-2xl"></i>
                                </div>
                            </div>
                        </div>
                        <span class="mt-8 text-xs dark:text-white">Créez une story</span>
                    </div>
                    
                    <!-- Stories des amis -->
                    <div class="flex flex-col items-center">
                        <div class="relative">
                            <div class="w-32 h-48 rounded-lg overflow-hidden story-item">
                                <img src="https://picsum.photos/300/450" class="w-full h-full object-cover opacity-90">
                            </div>
                            <div class="absolute top-2 left-2">
                                <div class="w-8 h-8 rounded-full border-2 border-blue-500 overflow-hidden">
                                    <img src="https://picsum.photos/100" class="w-full h-full object-cover">
                                </div>
                            </div>
                            <div class="absolute bottom-2 left-2 right-2">
                                <span class="text-white text-sm font-semibold">Jean Dupont</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex flex-col items-center">
                        <div class="relative">
                            <div class="w-32 h-48 rounded-lg overflow-hidden story-item">
                                <img src="https://picsum.photos/301/451" class="w-full h-full object-cover opacity-90">
                            </div>
                            <div class="absolute top-2 left-2">
                                <div class="w-8 h-8 rounded-full border-2 border-blue-500 overflow-hidden">
                                    <img src="https://picsum.photos/101" class="w-full h-full object-cover">
                                </div>
                            </div>
                            <div class="absolute bottom-2 left-2 right-2">
                                <span class="text-white text-sm font-semibold">Marie Martin</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
            <!-- Créer un post -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-4 p-4">
                <div class="flex items-center gap-2 mb-4">
                    <img src="https://readdy.ai/api/search-image?query=professional%20headshot%20of%20a%20young%20french%20man%20with%20friendly%20smile%2C%20natural%20lighting%2C%20high%20quality&width=40&height=40&seq=2&orientation=squarish" class="w-10 h-10 rounded-full object-cover">
                    <div class="flex-1">
                        <textarea id="post-textarea" placeholder="Quoi de neuf ?" class="w-full p-2 bg-gray-50 dark:bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                </div>
                <div class="flex justify-between items-center mt-4">
                    <div class="flex gap-2">
                        <button class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                            <a href="?page=mediaPost" class="spa-link">
                                <i class="ri-image-line text-blue-500"></i>
                            </a>
                        </button>
                        <button class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                            <a href="?page=mediaPost" class="spa-link">
                                <i class="ri-video-line text-red-500"></i>
                            </a>
                        </button>
                    </div>
                    <button id="btn-publier" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Publier</button>
                </div>
                <div id="post-error" class="text-red-500 text-sm mt-2" style="display:none;"></div>
            </div>
            
            <!-- Container pour les posts -->
            <div id="posts-container" class="space-y-4"></div>

            <!-- Container pour les Reels -->
            <div id="reels-container" class="space-y-4"></div>
        </main>

        <!-- Sidebar droite -->
    </div>

</body>
</html>
<script>
// Fonction pour publier un post texte
async function publierPostTexte() {
    const textarea = document.getElementById('post-textarea');
    const btn = document.getElementById('btn-publier');
    const errorDiv = document.getElementById('post-error');
    const content = textarea.value.trim();
    if (!content) {
        errorDiv.textContent = 'Veuillez saisir un texte.';
        errorDiv.style.display = '';
        return;
    }
    errorDiv.style.display = 'none';
    btn.disabled = true;
    btn.textContent = 'Publication...';
    try {
        const res = await fetch('api/posts/createTextPost.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ description: content })
        });
        const data = await res.json();
        if (data.success) {
            textarea.value = '';
            chargerPosts();
        } else {
            errorDiv.textContent = data.message || 'Erreur lors de la publication.';
            errorDiv.style.display = '';
        }
    } catch (e) {
        errorDiv.textContent = 'Erreur de connexion.';
        errorDiv.style.display = '';
    }
    btn.disabled = false;
    btn.textContent = 'Publier';
}

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('btn-publier').onclick = publierPostTexte;
    chargerPosts();
});

// Fonction pour charger les posts (existant)
async function chargerPosts() {
    const container = document.getElementById('posts-container');
    container.innerHTML = '<div class="text-gray-400 text-center py-8">Chargement...</div>';
    try {
        const res = await fetch('api/posts/getPost.php');
        const data = await res.json();
        if (!data.success || !data.posts || !data.posts.length) {
            container.innerHTML = '<div class="text-gray-400 text-center py-8">Aucun post</div>';
            return;
        }
        container.innerHTML = data.posts.map(post => `
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 mb-2">
                <div class="flex items-center gap-2 mb-2">
                    <img src="${post.profil || 'assets/images/default-avatar.jpg'}" class="w-10 h-10 rounded-full object-cover">
                    <div>
                        <div class="font-semibold text-gray-800 dark:text-white">${post.firstname} ${post.lastname}</div>
                        <div class="text-xs text-gray-500">${new Date(post.created_at).toLocaleString()}</div>
                    </div>
                </div>
                <div class="text-gray-900 dark:text-white">${post.description || ''}</div>
            </div>
        `).join('');
    } catch (e) {
        container.innerHTML = '<div class="text-red-500 text-center py-8">Erreur de chargement</div>';
    }
}
</script>
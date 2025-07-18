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

<div class="flex">
    <!-- Aside -->
    <aside class="w-64 bg-gray-50 dark:bg-gray-900 min-h-screen p-4 hidden md:block">
        <nav>
            <ul class="space-y-2">
                <li><a href="?page=profil" class="block py-2 px-4 rounded hover:bg-gray-200 dark:hover:bg-gray-700">Mon Profil</a></li>
                <li><a href="?page=photos" class="block py-2 px-4 rounded bg-blue-100 dark:bg-blue-900 font-bold">Photos</a></li>
                <li><a href="?page=videos" class="block py-2 px-4 rounded hover:bg-gray-200 dark:hover:bg-gray-700">Vidéos</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Main content -->
    <main class="flex-1 p-6">
        <h2 class="text-2xl font-bold mb-4">Mes Photos</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <!-- Exemple d'affichage de photos -->
            <img src="assets/profil/1.jpg" alt="Photo 1" class="rounded shadow">
            <img src="assets/profil/2.jpg" alt="Photo 2" class="rounded shadow">
            <img src="assets/couverture/6874fbfe16875.jpg" alt="Photo 3" class="rounded shadow">
            <!-- Ajoute ici une boucle PHP pour afficher dynamiquement les photos -->
        </div>
    </main>
</div>

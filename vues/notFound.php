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

    <main class="flex flex-col items-center justify-center min-h-[calc(100vh-56px)] p-4">
        <div class="max-w-md w-full bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden p-8 text-center">
            <!-- Animation -->
            <div class="relative mb-8 h-40">
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="text-8xl text-gray-300 dark:text-gray-600 animate-pulse-slow">404</div>
                </div>
                <div class="relative flex justify-center animate-float">
                    <svg class="w-32 h-32 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Message -->
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">Oups ! Page introuvable</h1>
            <p class="text-gray-600 dark:text-gray-300 mb-6">
                La page que vous cherchez semble avoir disparu dans un trou noir ou n'a peut-être jamais existé.
            </p>

            <!-- Boutons d'action -->
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="?page=acceuil" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors flex items-center justify-center gap-2">
                    <i class="ri-home-4-line"></i>
                    <span>Retour à l'accueil</span>
                </a>
                <button onclick="window.history.back()" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-white font-medium rounded-lg transition-colors flex items-center justify-center gap-2">
                    <i class="ri-arrow-left-line"></i>
                    <span>Retour en arrière</span>
                </button>
            </div>

            <!-- Recherche -->
            <div class="mt-8">
                <p class="text-gray-500 dark:text-gray-400 mb-3 text-sm">Ou essayez une recherche :</p>
                <div class="relative max-w-xs mx-auto">
                    <input type="text" placeholder="Rechercher sur Facebook..." class="w-full bg-gray-100 dark:bg-gray-700 border-none rounded-full pl-10 pr-4 py-2 text-gray-800 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600">
                    <i class="ri-search-line absolute left-3 top-2.5 text-gray-500 dark:text-gray-400"></i>
                </div>
            </div>
        </div>
    </main>

    <script>

                tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    animation: {
                        'float': 'float 3s ease-in-out infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        }
                    }
                }
            }
        }

        // Toggle dark mode
        const themeToggle = document.getElementById('theme-toggle');
        themeToggle.addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'));
        });

        // Check for saved theme preference
        if (localStorage.getItem('darkMode') === 'true') {
            document.documentElement.classList.add('dark');
        } else if (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            document.documentElement.classList.add('dark');
        }
    </script>
</body>
</html>
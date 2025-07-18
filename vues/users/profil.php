<body class="bg-[#f0f2f5] dark:bg-[#18191a] min-h-screen">
    <!-- Header identique aux pages précédentes -->
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

    <div class="max-w-6xl mx-auto">
        <!-- Photo de couverture -->
        <div class="cover-photo relative w-full bg-gray-200 dark:bg-gray-700 rounded-b-lg overflow-hidden">
            <img src="https://picsum.photos/1600/900" class="w-full h-full object-cover">
            <div class="absolute bottom-4 right-4">
                <button class="bg-white dark:bg-[#3a3b3c] text-gray-800 dark:text-white px-3 py-1.5 rounded-md font-medium flex items-center gap-2 hover:bg-gray-100 dark:hover:bg-[#4e4f50]">
                    <i class="ri-camera-line"></i>
                    <span>Modifier</span>
                </button>
            </div>
        </div>

        <!-- Section profil -->
        <div class="px-4 relative">
            <!-- Photo de profil -->
            <div class="absolute -top-20 left-4 md:left-8">
                <div class="profile-photo w-40 h-40 rounded-full overflow-hidden bg-white dark:bg-[#3a3b3c]">
                    <img src="https://readdy.ai/api/search-image?query=professional%20headshot%20of%20a%20young%20french%20man%20with%20friendly%20smile%2C%20natural%20lighting%2C%20high%20quality&width=400&height=400&seq=2&orientation=squarish" class="w-full h-full object-cover">
                </div>
            </div>

            <!-- Actions profil -->
            <div class="flex justify-end pt-4 pb-2">
                <div class="profile-actions flex gap-2">
                  
                    <button id="edit-profile-btn" class="w-full mt-4 bg-[#e4e6eb] dark:bg-[#3a3b3c] text-gray-800 dark:text-white px-3 py-1.5 rounded-md font-medium hover:bg-gray-300 dark:hover:bg-[#4e4f50]">
                        <i class="ri-edit-box-line"></i>
                        <span class="hidden md:inline">Modifier le profil</span>
                    </button>
                    <button class="bg-primary hover:bg-primary-hover text-white px-3 py-1.5 rounded-md font-medium add-friend-btn">
                        <i class="ri-user-add-line"></i>
                    </button>
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-md font-medium flex items-center gap-2 message-friend-btn" style="display: none;">
                        <i class="ri-message-3-line"></i>
                        <span class="hidden md:inline">Message</span>
                    </button>
                </div>
            </div>

            <!-- Infos utilisateur -->
            <div class="mt-16 md:mt-4 mb-4">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white"></h1>
                <p class="bio-profil"></p>
                <a class="website-profil" href="#"></a>
                <span class="location-profil"></span>
                <span class="joined-profil"></span>
                <span class="nb-amis-profil"></span>
                <div class="mini-amis-profil grid grid-cols-2 gap-3"></div>
            </div>

            <!-- Navigation profil -->
            <div class="border-t dark:border-[#3e4042]">
                <nav class="flex overflow-x-auto scrollbar-hide">
                    <a href="#" class="nav-item px-4 py-3 font-medium text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white active-nav text-primary dark:text-white">
                        <span class="spa-link whitespace-nowrap">Publications</span>
                    </a>
                    <a href="?page=amis" class="nav-item px-4 spa-link py-3 font-medium text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                        <span class="whitespace-nowrap">Amis</span>
                    </a>
                    <a href="?page=photos" class="nav-item px-4 spa-link py-3 font-medium text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                        <span class="whitespace-nowrap">Photos</span>
                    </a>
                    <a href="?page=videos" class="nav-item  spa-link  px-4 py-3 font-medium text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                        <span class="whitespace-nowrap">Vidéos</span>
                    </a>
                    <a href="?page=update" class="nav-item spa-link px-4 py-3 font-medium text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                        <span class="whitespace-nowrap">Modifier compte</span>
                    </a>
                </nav>
            </div>
        </div>

        <!-- Contenu principal -->
        <div class="flex flex-col md:flex-row gap-4 px-4 pb-4">
            <!-- Colonne gauche -->
            <div class="w-full md:w-1/3 space-y-4">
                <!-- À propos -->
                <div class="bg-white dark:bg-[#242526] rounded-lg shadow p-4">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">À propos</h2>

                    <div class="space-y-3">
                        <div>
                            <h3 class="font-semibold text-gray-800 dark:text-white">Informations personnelles</h3>
                            <ul class="mt-1 space-y-2">
                                <li class="text-gray-600 dark:text-gray-300 flex items-start gap-2">
                                    <i class="ri-home-3-line mt-1"></i>
                                    <span class="hometown-profil">À compléter</span>
                                </li>
                                <li class="text-gray-600 dark:text-gray-300 flex items-start gap-2">
                                    <i class="ri-map-pin-line mt-1"></i>
                                    <span class="location-profil">À compléter</span>
                                </li>
                                <li class="text-gray-600 dark:text-gray-300 flex items-start gap-2">
                                    <i class="ri-calendar-line mt-1"></i>
                                    <span class="birthdate-profil">À compléter</span>
                                </li>
                                <li class="text-gray-600 dark:text-gray-300 flex items-start gap-2">
                                    <i class="ri-user-line mt-1"></i>
                                    <span class="gender-profil">À compléter</span>
                                </li>
                                <li class="text-gray-600 dark:text-gray-300 flex items-start gap-2">
                                    <i class="ri-heart-line mt-1"></i>
                                    <span class="relationship-profil">À compléter</span>
                                </li>
                            </ul>
                        </div>
                        
                        <div>
                            <h3 class="font-semibold text-gray-800 dark:text-white">Contact</h3>
                            <ul class="mt-1 space-y-2">
                                <li class="text-gray-600 dark:text-gray-300 flex items-start gap-2">
                                    <i class="ri-mail-line mt-1"></i>
                                    <span class="email-profil"></span>
                                </li>
                                <li class="text-gray-600 dark:text-gray-300 flex items-start gap-2">
                                    <i class="ri-phone-line mt-1"></i>
                                    <span class="phone-profil"></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <button id="edit-infos-btn" class="w-full mt-4 bg-[#e4e6eb] dark:bg-[#3a3b3c] text-gray-800 dark:text-white px-3 py-1.5 rounded-md font-medium hover:bg-gray-300 dark:hover:bg-[#4e4f50]">
                        Modifier les informations 
                    </button>
                </div>

                <!-- Photos -->
                <div class="bg-white dark:bg-[#242526] rounded-lg shadow p-4">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-gray-800 dark:text-white">Photos</h2>
                    </div>
                    <div class="photos-section grid grid-cols-3 gap-1">
                        <!-- Les photos seront chargées dynamiquement ici -->
                    </div>
                </div>

                <!-- Vidéos -->
                <div class="bg-white dark:bg-[#242526] rounded-lg shadow p-4">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-gray-800 dark:text-white">Vidéos</h2>
                    </div>
                    <div class="videos-section grid grid-cols-2 gap-2">
                        <!-- Les vidéos seront chargées dynamiquement ici -->
                    </div>
                </div>

                <!-- Amis -->
                <div class="bg-white dark:bg-[#242526] rounded-lg shadow p-4">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-gray-800 dark:text-white">Amis</h2>
                    </div>
                    
                    <p class="text-gray-600 dark:text-gray-300 mb-3 nb-amis-profil">0 amis</p>
                    
                    <div class="mini-amis-profil grid grid-cols-2 gap-3">
                        <!-- Les amis seront chargés dynamiquement ici -->
                    </div>
                </div>
            </div>

            <!-- Colonne droite (Publications) -->
            <div class="w-full md:w-2/3 space-y-4">
                <!-- Créer une publication -->
                <div class="bg-white dark:bg-[#242526] rounded-lg shadow p-4">
                    <div class="flex items-center gap-2 mb-4">
                        <img src="https://readdy.ai/api/search-image?query=professional%20headshot%20of%20a%20young%20french%20man%20with%20friendly%20smile%2C%20natural%20lighting%2C%20high%20quality&width=40&height=40&seq=2&orientation=squarish" class="w-10 h-10 rounded-full object-cover">
                        <input type="text" placeholder="Quoi de neuf, Jean ?" class="flex-1 bg-[#f0f2f5] dark:bg-[#3a3b3c] rounded-full px-4 py-2 border-none outline-none text-gray-800 dark:text-white dark:placeholder-gray-300">
                    </div>
                    <div class="flex justify-between border-t dark:border-[#3e4042] pt-3">
                        <button class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-[#3a3b3c] text-gray-600 dark:text-gray-300">
                            <i class="ri-live-fill text-red-500"></i>
                            <span>Live vidéo</span>
                        </button>
                        <button class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-[#3a3b3c] text-gray-600 dark:text-gray-300">
                            <i class="ri-image-2-fill text-green-500"></i>
                            <span>Photo/vidéo</span>
                        </button>
                        <button class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-[#3a3b3c] text-gray-600 dark:text-gray-300">
                            <i class="ri-emotion-happy-fill text-yellow-500"></i>
                            <span>Humeur</span>
                        </button>
                    </div>
                </div>

                <!-- Publications -->
                <div class="bg-white dark:bg-[#242526] rounded-lg shadow publications-section">
                    <!-- Les publications seront chargées dynamiquement ici -->
                </div>
            </div>
        </div>
    </div>

<!-- Modal de modification de la couverture -->
<div id="modal-cover" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white dark:bg-[#242526] rounded-lg shadow-lg p-6 w-full max-w-md relative">
        <button id="close-modal-cover" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-2xl">&times;</button>
        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">Modifier la photo de couverture</h2>
        <div class="mb-4">
            <img id="current-cover-preview" src="" alt="Aperçu couverture" class="w-full h-40 object-cover rounded mb-2 border">
        </div>
        <input type="file" id="cover-file-input" accept="image/*" class="mb-4">
        <div id="new-cover-preview-container" class="mb-4 hidden">
            <p class="text-sm text-gray-600 dark:text-gray-300 mb-1">Aperçu de la nouvelle image :</p>
            <img id="new-cover-preview" src="" alt="Aperçu nouvelle couverture" class="w-full h-40 object-cover rounded border">
        </div>
        <button id="save-cover-btn" class="w-full bg-primary text-white py-2 rounded font-medium hover:bg-primary-hover">Enregistrer</button>
    </div>
</div>

<!-- Modal de modification de la photo de profil -->
<div id="modal-profil" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white dark:bg-[#242526] rounded-lg shadow-lg p-6 w-full max-w-md relative">
        <button id="close-modal-profil" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-2xl">&times;</button>
        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">Modifier la photo de profil</h2>
        <div class="mb-4">
            <img id="current-profil-preview" src="" alt="Aperçu profil" class="w-full h-40 object-cover rounded mb-2 border">
        </div>
        <input type="file" id="profil-file-input" accept="image/*" class="mb-4">
        <div id="new-profil-preview-container" class="mb-4 hidden">
            <p class="text-sm text-gray-600 dark:text-gray-300 mb-1">Aperçu de la nouvelle image :</p>
            <img id="new-profil-preview" src="" alt="Aperçu nouvelle photo de profil" class="w-full h-40 object-cover rounded border">
        </div>
        <button id="save-profil-btn" class="w-full bg-primary text-white py-2 rounded font-medium hover:bg-primary-hover">Enregistrer</button>
    </div>
</div>
</body>
</html>
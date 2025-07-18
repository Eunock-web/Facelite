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

<!-- vues/users/profil_edit.php -->
<main class="flex-1">
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow-sm p-6 max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Modifier vos informations</h1>
        
        <form id="edit-profile-form" class="space-y-6 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 p-6">
            <!-- Section Informations de base -->
            <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                <h2 class="text-lg font-medium text-gray-800 dark:text-white mb-4">Informations de base</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="firstname" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Prénom</label>
                        <input type="text" id="firstname" name="firstname" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary dark:bg-gray-800 dark:text-white">
                    </div>
                    <div>
                        <label for="lastname" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nom</label>
                        <input type="text" id="lastname" name="lastname" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary dark:bg-gray-800 dark:text-white">
                    </div>
                </div>
                <div class="mt-4">
                    <label for="bio" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bio</label>
                    <textarea id="bio" name="bio" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary dark:bg-gray-800 dark:text-white"></textarea>
                </div>
            </div>
            <!-- Section Contact -->
            <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                <h2 class="text-lg font-medium text-gray-800 dark:text-white mb-4">Informations de contact</h2>
                <div class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                        <input type="email" id="email" name="email"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary dark:bg-gray-800 dark:text-white">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Téléphone</label>
                        <input type="tel" id="phone" name="phone"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary dark:bg-gray-800 dark:text-white">
                    </div>
                </div>
            </div>
            <!-- Section Vie privée -->
            <div class="pb-6">
                <h2 class="text-lg font-medium text-gray-800 dark:text-white mb-4">Vie privée</h2>
                <div class="space-y-4">
                    <div>
                        <label for="visibility" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Visibilité du profil</label>
                        <select id="visibility" name="visibility"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary dark:bg-gray-800 dark:text-white">
                            <option value="public">Public</option>
                            <option value="friends">Amis seulement</option>
                            <option value="private">Privé</option>
                        </select>
                    </div>
                    <div class="flex items-center">
                        <input id="show-email" name="show-email" type="checkbox"
                               class="h-4 w-4 text-primary focus:ring-primary border-gray-300 dark:border-gray-600 rounded dark:bg-gray-800">
                        <label for="show-email" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Afficher mon email publiquement</label>
                    </div>
                </div>
            </div>
            <!-- Section Profession -->
            <div class="pb-6">
                <h2 class="text-lg font-medium text-gray-800 dark:text-white mb-4">Profession</h2>
                <div class="space-y-4">
                    <div>
                        <label for="job_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Profession</label>
                        <input type="text" id="job_title" name="job_title"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary dark:bg-gray-800 dark:text-white">
                    </div>
                    <div>
                        <label for="company" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Entreprise</label>
                        <input type="text" id="company" name="company"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary dark:bg-gray-800 dark:text-white">
                    </div>
                    <div>
                        <label for="education" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Éducation</label>
                        <input type="text" id="education" name="education"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary dark:bg-gray-800 dark:text-white">
                    </div>
                </div>
            </div>
            <!-- Section Situation amoureuse -->
            <div class="pb-6">
                <h2 class="text-lg font-medium text-gray-800 dark:text-white mb-4">Situation amoureuse</h2>
                <div>
                    <label for="relationship_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Situation amoureuse</label>
                    <select id="relationship_status" name="relationship_status"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary dark:bg-gray-800 dark:text-white">
                        <option value="À compléter">À compléter</option>
                        <option value="Célibataire">Célibataire</option>
                        <option value="En couple">En couple</option>
                        <option value="Marié(e)">Marié(e)</option>
                        <option value="Divorcé(e)">Divorcé(e)</option>
                        <option value="Veuf/Veuve">Veuf/Veuve</option>
                    </select>
                </div>
            </div>
            <!-- Boutons d'action -->
            <div class="flex justify-end space-x-3">
                <button type="button" id="cancel-edit"
                        class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-white bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    Annuler
                </button>
                <button type="submit"
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
</main>

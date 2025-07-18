
<div class="bg-gray-100 dark:bg-gray-900 min-h-screen flex items-center justify-center p-4 transition-colors duration-300">
        
        <div class="flex flex-col lg:flex-row">
            <!-- Image div - hidden on small screens, visible on large screens -->
            <div class="hidden lg:block lg:w-1/2 bg-facebook-blue dark:bg-blue-900 p-8 flex items-center justify-center transition-colors duration-300">
                <img src="assets/images/facebook.png" alt="Facebook" class="">
            </div>
            
            <!-- Form section -->
            <div class="w-full lg:w-1/2 p-8">
                <h1 class="text-3xl font-bold text-center text-facebook-blue dark:text-blue-400 mb-8 transition-colors duration-300">FaceLite</h1>
                
                <form class="space-y-6" id="form-reset-email">
                    <div class="space-y-4">
                        <div class="mb-8">
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 transition-colors duration-300">E-mail</label>
                            <input type="email" id="email" name="email" required 
                                   placeholder="erwinmith@gmail.com"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-facebook-blue focus:border-facebook-blue dark:bg-gray-700 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-colors duration-300">
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 transition-colors duration-300">Nouveau mot de passe</label>    
                            <input type="password" id="password" name="password" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-facebook-blue focus:border-facebook-blue dark:bg-gray-700 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-colors duration-300">
                        </div>
                    </div>
                    
                    <div>
                        <button type="submit" name="updatePassword" id="updatePassword"
                                class="w-full flex justify-center py-4 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-facebook-blue hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-facebook-blue dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-500 transition-colors duration-300 mt-3">
                            Modifier mot de passe   
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


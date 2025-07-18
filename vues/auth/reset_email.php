
<div class="bg-gray-100 dark:bg-gray-900 min-h-screen flex items-center justify-center p-4 transition-colors duration-300">
      
    <div id="error-message" class="fixed top-20 right-4 max-w-xs w-full bg-red-100 dark:bg-red-900 border-l-4 border-red-500 dark:border-red-700 text-red-700 dark:text-red-100 p-4 rounded shadow-lg hidden transition-all duration-300 z-50">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-500 dark:text-red-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p id="error-text" class="text-sm font-medium"></p>
            </div>
            <div class="ml-auto pl-3">
                <button id="close-error" class="text-red-500 dark:text-red-300 hover:text-red-700 dark:hover:text-red-100">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
            <!-- Form section -->
            <div class="w-[470px] p-8 items-center">
                <h1 class="text-3xl font-bold text-center text-facebook-blue dark:text-blue-400 mb-8 transition-colors duration-300">FaceLite</h1>
                
                <form class="space-y-6" id="sendEmail" method="post">
                    <div class="space-y-4">
                        <p class="text-center text-gray-700 dark:text-gray-300 transition-colors duration-300">Entrez votre E-mail</p>
                        <div class="mb-8">
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 transition-colors duration-300">E-mail</label>
                            <input type="email" name="email" required 
                                   placeholder="erwinmith@gmail.com"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-facebook-blue focus:border-facebook-blue dark:bg-gray-700 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-colors duration-300">
                        </div>

                    </div>
                    
                    <div>
                        <button type="submit" name="updatePassword" 
                                class="w-full flex justify-center py-4 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-facebook-blue hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-facebook-blue dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-500 transition-colors duration-300 mt-3">
                            Envoyer   
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


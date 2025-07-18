    <div class="bg-white rounded-2xl shadow-md p-8 w-full max-w-md mx-auto">
        <!-- Logo Facebook -->
        <div class="text-center mb-4">
            <img src="https://static.xx.fbcdn.net/rsrc.php/y8/r/dF5SId3UHWd.svg" 
                 alt="Facebook Logo" 
                 class="h-12 mx-auto"
                 onerror="this.onerror=null;this.src='https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg';">
        </div>
        
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Vérifiez votre email</h1>
            <p class="text-gray-600">Entrez le code de vérification envoyé dans votre Mail</p>
            <!-- <p class="font-medium text-gray-800 mt-1">uituxmadhura@gmail.com</p> -->
        </div>
        
        <!-- Champs OTP -->
        <div class="flex justify-center gap-3 mb-8">
            <input type="text" maxlength="1" 
                   class="otp-input w-12 h-12 text-2xl text-center border-2 border-gray-200 rounded-lg 
                          focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-200
                          transition duration-150">
            <input type="text" maxlength="1" 
                   class="otp-input w-12 h-12 text-2xl text-center border-2 border-gray-200 rounded-lg 
                          focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-200
                          transition duration-150">
            <input type="text" maxlength="1" 
                   class="otp-input w-12 h-12 text-2xl text-center border-2 border-gray-200 rounded-lg 
                          focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-200
                          transition duration-150">
            <input type="text" maxlength="1" 
                   class="otp-input w-12 h-12 text-2xl text-center border-2 border-gray-200 rounded-lg 
                          focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-200
                          transition duration-150">
            <input type="text" maxlength="1" 
                   class="otp-input w-12 h-12 text-2xl text-center border-2 border-gray-200 rounded-lg 
                          focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-200
                          transition duration-150">    
            <input type="text" maxlength="1" 
                   class="otp-input w-12 h-12 text-2xl text-center border-2 border-gray-200 rounded-lg 
                          focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-200
                          transition duration-150">
        </div>

        
        <!-- Lien Renvoyer -->
        <div class="text-center mb-6">
            <p class="text-gray-500">
                Vous n'avez pas reçu de code ? 
                <a href="?action=resend_code" class="text-blue-600 hover:underline font-medium" id="resendCode_link">Renvoyer</a>
            </p>
        </div>
        
        <!-- Bouton de vérification -->
        <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 
                      rounded-lg transition duration-200 shadow-md" id="email_btn_confirm">
            Vérifier l'email
        </button>
    </div>



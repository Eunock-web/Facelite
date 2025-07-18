// Script de validation du code OTP pour Facebook
document.addEventListener('DOMContentLoaded', function() {
    // Récupération des éléments
    const otpInputs = document.querySelectorAll('input[type="text"]');
    const confirmBtn = document.getElementById('email_btn_confirm');
    const resendLink = document.getElementById('resendCode_link');
    
    // Gestion de la saisie automatique dans les champs OTP
    otpInputs.forEach((input, index) => {
        input.addEventListener('input', function(e) {
            const value = e.target.value;
            
            // Permettre seulement les chiffres
            if (!/^\d*$/.test(value)) {
                e.target.value = '';
                return;
            }
            
            // Passer au champ suivant automatiquement
            if (value.length === 1 && index < otpInputs.length - 1) {
                otpInputs[index + 1].focus();
            }
        });
        
        // Gestion du retour en arrière
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && !e.target.value && index > 0) {
                otpInputs[index - 1].focus();
            }
        });
    });
    
    // Fonction pour obtenir le code complet
    function getOTPCode() {
        let code = '';
        otpInputs.forEach(input => {
            code += input.value;
        });
        return code;
    }
    
    // Fonction pour afficher les messages
    function showMessage(message, isError = false) {
        // Supprimer le message précédent s'il existe
        const existingMessage = document.getElementById('verification-message');
        if (existingMessage) {
            existingMessage.remove();
        }
        
        // Créer le nouveau message
        const messageDiv = document.createElement('div');
        messageDiv.id = 'verification-message';
        messageDiv.className = `mb-4 p-4 rounded-lg text-center font-medium ${
            isError 
                ? 'bg-red-100 border border-red-400 text-red-700' 
                : 'bg-green-100 border border-green-400 text-green-700'
        }`;
        messageDiv.textContent = message;
        
        // Insérer le message avant le bouton
        confirmBtn.parentNode.insertBefore(messageDiv, confirmBtn);
        
        // Supprimer le message après 5 secondes
        setTimeout(() => {
            if (messageDiv.parentNode) {
                messageDiv.remove();
            }
        }, 5000);
    }
    
    // Fonction pour vider les champs OTP
    function clearOTPFields() {
        otpInputs.forEach(input => {
            input.value = '';
        });
        otpInputs[0].focus();
    }
    
    // Fonction pour valider le code OTP
    async function validateOTP() {
        const code = getOTPCode();
        
        // Vérifier que tous les champs sont remplis
        if (code.length !== 6) {
            showMessage('Veuillez saisir le code de vérification complet (6 chiffres)', true);
            return;
        }
        
        // Désactiver le bouton pendant la validation
        confirmBtn.disabled = true;
        confirmBtn.textContent = 'Vérification en cours...';
        
        try {
            // Envoyer la requête à l'API
            const response = await fetch('../../api/otp/code_confirm.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    verification_code: code
                })
            });
            
            // Analyser la réponse
            const result = await response.json();
            
            if (response.ok && result.success) {
                // Succès
                showMessage('Code de vérification validé avec succès !', false);
                
                // Attendre 2 secondes puis rediriger
                setTimeout(() => {
                history.pushState(null, "", "http://localhost/FaceLite2/vues/users/profil.php"); // Redirection après 3 secondes
                }, 2000);
                
            } else {
                // Erreur de validation
                const errorMessage = result.message || 'Code de vérification invalide. Veuillez réessayer.';
                showMessage(errorMessage, true);
                clearOTPFields();
            }
            
        } catch (error) {
            console.error('Erreur lors de la validation:', error);
            showMessage('Erreur de connexion. Veuillez réessayer.', true);
            clearOTPFields();
        } finally {
            // Réactiver le bouton
            confirmBtn.disabled = false;
            confirmBtn.textContent = 'Vérifier l\'email';
        }
    }
    
    // Fonction pour renvoyer le code
    async function resendCode() {
        try {
            const response = await fetch('../../api/otp/resend_code.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });
            
            const result = await response.json();
            
            if (response.ok && result.success) {
                showMessage('Nouveau code de vérification envoyé !', false);
                clearOTPFields();
            } else {
                showMessage(result.message || 'Erreur lors du renvoi du code', true);
            }
            
        } catch (error) {
            console.error('Erreur lors du renvoi:', error);
            showMessage('Erreur lors du renvoi du code', true);
        }
    }
    
    // Événements
    confirmBtn.addEventListener('click', validateOTP);
    
    // Permettre la validation avec Enter
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            validateOTP();
        }
    });
    
    // Gestion du lien "Renvoyer"
    resendLink.addEventListener('click', function(e) {
        e.preventDefault();
        resendCode();
    });
    
    // Focus sur le premier champ au chargement
    otpInputs[0].focus();
});

// Exemple de structure attendue pour la réponse de code_confirm.php :
/*
Succès:
{
    "success": true,
    "message": "Code validé avec succès"
}

Erreur:
{
    "success": false,
    "message": "Code de vérification invalide"
}
*/
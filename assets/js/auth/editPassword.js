        const updatePasswordForm = document.getElementById('updatePasswordForm');
        if (updatePasswordForm) {
            updatePasswordForm.addEventListener('submit', (e) => {
                e.preventDefault();
                let formData = new FormData(updatePasswordForm);
                fetch("api/auth/editPassword.php", {
                    method: "POST",
                    headers: {"Content-Type": "application/json"},
                    body: JSON.stringify(Object.fromEntries(formData))
                })
                .then(response => {
                    if (!response.ok) throw new Error("Erreur réseau");
                    return response.json();
                })
                .then(data => {
                    const errorMessage = document.getElementById('error-message');
                    const errorText = document.getElementById('error-text');
                    errorText.textContent = data.message;
                    errorMessage.classList.remove('hidden');
                    if (data.success) {
                        errorMessage.style.backgroundColor = '#d1fae5';
                        setTimeout(() => {
                            window.chargerPage("login");
                        }, 2000);
                    } else {
                        errorMessage.style.backgroundColor = '#fee2e2';
                        setTimeout(() => {
                            errorMessage.classList.add('hidden');
                        }, 2000);
                    }
                })
                .catch(err => {
                    console.error("Erreur:", err);
                    const errorMessage = document.getElementById('error-message');
                    const errorText = document.getElementById('error-text');
                    errorText.textContent = "Une erreur inattendue s'est produite";
                    errorMessage.classList.remove('hidden');
                    errorMessage.style.backgroundColor = '#fee2e2';
                });
            });
        }

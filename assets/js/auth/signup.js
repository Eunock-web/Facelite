        // Fonction pour basculer entre l'affichage et le masquage du mot de passe
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        // // Fonction pour basculer entre les thèmes sombre et clair
        // document.getElementById('themeToggle').addEventListener('click', function() {
        //     document.documentElement.classList.toggle('dark');
        //     localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'));
        // });

        // // Vérifier le thème au chargement de la page
        // if (localStorage.getItem('darkMode') === 'true') {
        //     document.documentElement.classList.add('dark');
        // } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
        //     document.documentElement.classList.add('dark');
        //     localStorage.setItem('darkMode', 'true');
        // }


// let signupForm = document.getElementById("signup_form");

// signupForm.addEventListener('submit', (e) => {
//     e.preventDefault();
//     let formData = new FormData(signupForm);
    
//     fetch("../../api/auth/signup.php", {
//         method: "POST",
//         body: formData
//     })
//     .then(response => {
//         if (!response.ok) throw new Error("Erreur réseau");
//         return response.json();
//     })
//     .then(data => {
//         const errorMessage = document.getElementById('error-message');
//         const errorText = document.getElementById('error-text');
        
//         errorText.textContent = data.message;
//         errorMessage.classList.remove('hidden');
        
//         if (data.success) {
//             errorMessage.classList.add('bg-green-100'); // Style pour succès
//             setTimeout(() => {
//                 window.location.href = "index.php"; // Redirection si succès
//             }, 3000);
//         } else {
//             errorMessage.classList.add('bg-red-100'); // Style pour erreur
//             setTimeout(() => {
//                 errorMessage.classList.add('hidden');
//             }, 5000);
//         }
//     })
//     .catch(err => {
//         console.error("Erreur:", err);
//         // Afficher un message d'erreur générique
//     });
// });

// const body = document.getElementById("body");

// function chargerPartie(page, addHistory = true) {
//     fetch(`route.php?page=${page}`, { headers: { "X-Requested-With": "XMLHttpRequest" } })
//         .then(res => {
//             if (!res.ok) throw new Error("Erreur réseau");
//             return res.text();
//         })
//         .then(html => {
//             // Créer un DOM temporaire pour extraire le body de la page reçue
//             const tempDom = document.createElement('html');
//             tempDom.innerHTML = html;
//             const newBody = tempDom.querySelector('#body');
//             if (newBody) {
//                 document.getElementById('body').innerHTML = newBody.innerHTML;
//             } else {
//                 // Si pas de #body, on remplace tout le contenu
//                 document.getElementById('body').innerHTML = html;
//             }
//             if (addHistory) {
//                 history.pushState({ page }, '', `?page=${page}`);
//             }
//         })
//         .catch(err => {
//             console.error(err);
//             document.getElementById('body').innerHTML = "<p>Erreur de chargement</p>";
//         });
// }
// window.chargerPartie = chargerPartie;

let signupForm = document.getElementById("signup_form");

signupForm.addEventListener('submit', (e) => {
    e.preventDefault();
    let formData = new FormData(signupForm);
    
    fetch("api/otp/signup.php", {
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
            errorMessage.style.backgroundColor = '#d1fae5'; // Vert clair pour succès
            setTimeout(() => {
                window.chargerPage('confirm');
            }, 2000);
        } else {
            errorMessage.style.backgroundColor = '#fee2e2'; // Rouge clair pour erreur
            setTimeout(() => {
                errorMessage.classList.add('hidden');
            }, 3000);
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

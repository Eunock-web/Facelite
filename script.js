// utils.js - Fonctions utilitaires
const Utils = {
    showMessage: (message, isSuccess = false, duration = 4000) => {
        const messageDiv = document.createElement('div');
        messageDiv.className = `fixed top-10 right-3 max-w-xs w-full p-4 rounded shadow-lg z-50 ${
            isSuccess 
                ? 'bg-green-100 dark:bg-green-900 border-l-4 border-green-500 text-green-700 dark:text-green-100'
                : 'bg-red-100 dark:bg-red-900 border-l-4 border-red-500 text-red-700 dark:text-red-100'
        }`;
        messageDiv.innerHTML = `
            <div class="flex justify-between items-center">
                <span>${message}</span>
                <button class="ml-4" onclick="this.parentElement.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        document.body.appendChild(messageDiv);
        setTimeout(() => messageDiv.remove(), duration);
    },

    handleFetchError: async (response) => {
        if (!response.ok) {
            const error = await response.json().catch(() => ({ message: 'Erreur réseau' }));
            throw new Error(error.message || 'Erreur inattendue');
        }
        return response.json();
    },

    attachSPALinks: () => {
        // Supprimer les anciens event listeners pour éviter les doublons
        document.body.removeEventListener('click', Utils.handleSPAClick);
        
        // Ajouter le nouveau event listener
        document.body.addEventListener('click', Utils.handleSPAClick);
    },

    handleSPAClick: (e) => {
        const link = e.target.closest('a');
        if (link && link.getAttribute('href') && link.getAttribute('href').startsWith('?page=')) {
            e.preventDefault();
            const url = new URL(link.href, window.location.origin);
            const page = url.searchParams.get("page");
            // On garde tous les paramètres
            window.chargerPage(url.search, true);
        }
    }
};

// auth.js - Gestion de l'authentification
const Auth = {
    init: () => {
        Auth.attachLoginListener();
        Auth.attachSignupListener();
        Auth.attachSendEmailListener();
        Auth.attachEditPasswordListener();
        Auth.attachLoginUIHelpers();
    },

    attachLoginListener: () => {
        const loginForm = document.getElementById('login_Form');
        if (!loginForm) return;

        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(loginForm);
            
            try {
                const response = await fetch("api/auth/login.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(Object.fromEntries(formData))
                });
                
                const data = await Utils.handleFetchError(response);
                
                if (data.success) {
                    Utils.showMessage(data.message, true);
                    setTimeout(() => window.chargerPage("acceuil"), 1500);
                } else {
                    Utils.showMessage(data.message);
                }
            } catch (err) {
                Utils.showMessage(err.message);
            }
        });
    },

    attachSignupListener: () => {
        const signupForm = document.getElementById('signup_form');
        if (!signupForm) return;

        signupForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(signupForm);

            try {
                const response = await fetch("api/otp/signup.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(Object.fromEntries(formData))
                });

                const data = await Utils.handleFetchError(response);

                if (data.success) {
                    Utils.showMessage(data.message, true);
                    setTimeout(() => window.chargerPage('confirm'), 1500);
                } else {
                    Utils.showMessage(data.message);
                }
            } catch (err) {
                Utils.showMessage(err.message);
            }
        });
    },

    attachSendEmailListener: () => {
        const sendEmailForm = document.getElementById('sendEmail');
        if (!sendEmailForm) return;

        sendEmailForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(sendEmailForm);

            try {
                const response = await fetch("api/auth/insertEmail.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(Object.fromEntries(formData))
                });

                const data = await Utils.handleFetchError(response);

                if (data.success) {
                    Utils.showMessage(data.message, true);
                    setTimeout(() => window.chargerPage("confirmPass"), 1500);
                } else {
                    Utils.showMessage(data.message);
                }
            } catch (err) {
                Utils.showMessage(err.message);
            }
        });
    },

    attachEditPasswordListener: () => {
        const form = document.getElementById('form-reset-email');
        if (!form) return;

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(form);

            try {
                const response = await fetch('api/auth/editPassword.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(Object.fromEntries(formData))
                });

                const data = await Utils.handleFetchError(response);
                Utils.showMessage(data.message, data.success);
                
                if (data.success) {
                    setTimeout(() => window.chargerPage('login'), 1500);
                }
            } catch (err) {
                Utils.showMessage("Erreur lors de la modification du mot de passe");
            }
        });
    },

    attachLoginUIHelpers: () => {
        const togglePassword = document.getElementById('togglePassword');
        if (togglePassword) {
            togglePassword.addEventListener('click', function() {
                const password = document.getElementById('password');
                if (password) {
                    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                    password.setAttribute('type', type);
                    this.innerHTML = type === 'password' 
                        ? '<i class="fas fa-eye text-gray-400 hover:text-gray-600 cursor-pointer text-lg"></i>' 
                        : '<i class="fas fa-eye-slash text-gray-400 hover:text-gray-600 cursor-pointer text-lg"></i>';
                }
            });
        }
    }
};

// otp.js - Gestion des codes OTP
const OTP = {
    init: (type = 'email') => {
        OTP.setupOTPInputs();
        OTP.attachOTPListener(type);
    },

    setupOTPInputs: () => {
        const otpInputs = document.querySelectorAll('input.otp-input');
        if (!otpInputs.length) return;

        otpInputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                if (!/^\d*$/.test(e.target.value)) {
                    e.target.value = '';
                    return;
                }
                if (e.target.value.length === 1 && index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !e.target.value && index > 0) {
                    otpInputs[index - 1].focus();
                }
            });
        });

        otpInputs[0].focus();
    },

    attachOTPListener: (type) => {
        // Chercher les boutons avec les bons IDs
        let confirmBtn = null;
        if (type === 'email') {
            confirmBtn = document.getElementById('password_btn_confirm');
        } else if (type === 'signup') {
            confirmBtn = document.getElementById('email_btn_confirm');
        }
        
        const resendLink = document.getElementById('resendCode_link');

        if (confirmBtn) {
            confirmBtn.addEventListener('click', () => OTP.validateOTP(type));
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') OTP.validateOTP(type);
            });
        }

        if (resendLink) {
            resendLink.addEventListener('click', (e) => {
                e.preventDefault();
                OTP.resendCode(type);
            });
        }
    },

    getOTPCode: () => {
        return Array.from(document.querySelectorAll('input.otp-input'))
            .map(input => input.value)
            .join('');
    },

    validateOTP: async (type) => {
        const code = OTP.getOTPCode();
        if (code.length !== 6) {
            Utils.showMessage('Veuillez saisir le code complet (6 chiffres)');
            return;
        }

        const confirmBtn = document.getElementById(`${type}_btn_confirm`);
        if (confirmBtn) {
            confirmBtn.disabled = true;
            confirmBtn.textContent = 'Vérification en cours...';
        }

        try {
            const response = await fetch(`api/otp/code_confirm.php`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ verification_code: code })
            });

            const data = await Utils.handleFetchError(response);

            if (data.success) {
                Utils.showMessage(data.message, true);
                setTimeout(() => {
                    window.chargerPage(type === 'email' ? 'editPassword' : 'profil');
                }, 2000);
            } else {
                Utils.showMessage(data.message);
                OTP.clearOTPFields();
            }
        } catch (err) {
            Utils.showMessage(err.message);
            OTP.clearOTPFields();
        } finally {
            if (confirmBtn) {
                confirmBtn.disabled = false;
                confirmBtn.textContent = 'Vérifier';
            }
        }
    },

    resendCode: async (type) => {
        try {
            const response = await fetch('api/otp/resend_code.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ type: type })
            });

            const data = await Utils.handleFetchError(response);
            Utils.showMessage(data.message, data.success);
            if (data.success) OTP.clearOTPFields();
        } catch (err) {
            Utils.showMessage(err.message);
        }
    },

    clearOTPFields: () => {
        document.querySelectorAll('input.otp-input').forEach(input => {
            input.value = '';
        });
        document.querySelector('input.otp-input')?.focus();
    }
};

// commentaire.js - Gestion des commentaires
const Commentaire = {
    init: () => {
        Commentaire.setupCommentForm();
        Commentaire.loadComments();
    },

    loadComments: (postId) => {
        if (!postId) {
            console.error('ID du post manquant');
            return;
        }

        // Charger le post et les commentaires
        fetch(`api/acceuil/getCommentaire.php?postId=${postId}`, {
            method: "GET",
            headers: { 'Content-Type': 'application/json' },
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                console.error('Erreur serveur:', data.error);
                Utils.showMessage(data.error, false);
                return;
            }

            const postContainer = document.getElementById('post-container');
            const commentsSection = document.getElementById('comments-section');
            // Affichage du nombre de likes et commentaires
            const likeCountSpan = document.getElementById('like-count');
            const commentCountSpan = document.getElementById('comment-count');
            if (likeCountSpan && data.post) {
                likeCountSpan.innerHTML = `<i class='ri-heart-3-fill text-red-500'></i> ${data.post.post_likes_count || 0} J'aime`;
            }
            if (commentCountSpan && data.comments) {
                commentCountSpan.innerHTML = `<i class='ri-chat-3-line'></i> ${data.comments.length} Commentaires`;
            }
            
            if (!postContainer || !commentsSection) return;

            // Afficher le post
            if (data.post) {
                postContainer.innerHTML = `
                    <div class="bg-white dark:bg-[#242526] rounded-lg shadow mb-4">
                        <div class="p-4 border-b dark:border-[#3e4042]">
                            <div class="flex items-center gap-3 mb-3">
                                <img src="${data.post.post_user_avatar.replace(/^\//, '')}" class="w-10 h-10 rounded-full object-cover">
                                <div>
                                    <h4 class="font-semibold text-gray-800 dark:text-white">${data.post.post_lastname} ${data.post.post_firstname}</h4>
                                    <span class="text-gray-500 text-xs">${new Date(data.post.created_at).toLocaleString()}</span>
                                </div>
                            </div>
                            
                            <div class="px-3 pb-3">
                                <p class="text-gray-800 dark:text-white">${data.post.description}</p>
                            </div>
                            
                            ${data.post.type_post === 'image' ? `
                                <img src="${data.post.content.replace(/^\//, '')}" class="post-image">
                            ` : `
                                <video src="${data.post.content.replace(/^\//, '')}" class="post-image" controls></video>
                            `}
                        </div>
                    </div>
                `;
            }

            // Afficher les commentaires
            if (commentsSection) commentsSection.innerHTML = '';

            if (data.comments.length === 0) {
                if (commentsSection) commentsSection.innerHTML = '<p class="text-gray-500 dark:text-gray-400">Aucun commentaire pour le moment</p>';
                return;
            }

            data.comments.forEach(comment => {
                const commentElement = document.createElement('div');
                commentElement.className = 'comment-item p-4 hover:bg-[#f0f2f5] dark:hover:bg-[#3a3b3c] transition-colors';
                commentElement.innerHTML = `
                    <div class="flex gap-3">
                        <img src="${comment.user_avatar}" class="w-10 h-10 rounded-full object-cover">
                        <div class="flex-1">
                            <div class="bg-[#f0f2f5] dark:bg-[#3a3b3c] rounded-lg p-3">
                                <div class="mb-1">
                                    <span class="font-semibold text-gray-800 dark:text-white">${comment.firstname} ${comment.lastname}</span>
                                    <span class="text-gray-500 text-xs ml-2">${new Date(comment.created_at).toLocaleString()}</span>
                                </div>
                                <p class="text-gray-800 dark:text-white">${comment.content}</p>
                            </div>
                        </div>
                    </div>
                `;
                commentsSection.appendChild(commentElement);
            });
        })
        .catch(error => {
            console.error('Erreur:', error);
            Utils.showMessage('Erreur lors de la récupération des commentaires', false);
        });
    },

    setupCommentForm: () => {
        // const form = document.getElementById('comment-form');
        const comment_button = document.getElementById('comment-submit');
        const comment_input = document.getElementById('comment-input');
        if (!comment_button) return;

        comment_button.addEventListener('click', async (e) => {
            e.preventDefault();
            const content = comment_input.value.trim();
            const postId = new URLSearchParams(window.location.search).get('postId');
            console.log(content);
            console.log(postId);
            if (!content) {
                Utils.showMessage('Veuillez écrire un commentaire', false);
                return;
            }

            try {
                const response = await fetch('api/acceuil/addComment.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        postId: postId,
                        content: content
                    })
                });

                const data = await response.json();

                if (data.success) {
                    // Réinitialiser le formulaire
                    comment_input.value = '';
                    
                    // Recharger les commentaires pour afficher le nouveau commentaire
                    Commentaire.loadComments(postId);
                    
                    Utils.showMessage('Commentaire ajouté avec succès', true);
                } else {
                    Utils.showMessage(data.message || 'Erreur lors de l\'ajout du commentaire', false);
                }
            } catch (error) {
                console.error('Erreur:', error);
                Utils.showMessage('Erreur lors de l\'ajout du commentaire', false);
            }
        });
    },

    likePost: () => {
        document.querySelectorAll('.like-button').forEach(btn => {
            btn.addEventListener('click', async function() {
                const postId = this.dataset.postId;
                // Récupérer l'ID utilisateur depuis data-user-id, ou une variable globale si présente
                const userId = this.dataset.userId || window.currentUserId || null;

                if (!userId) {
                    Utils.showMessage("Vous devez être connecté pour liker.");
                    return;
                }

                try {
                    const response = await fetch('api/acceuil/likePost.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            user_id: userId,
                            post_id: postId
                        })
                    });
                    const data = await response.json();
                    if (data.success) {
                        // Mettre à jour le nombre de likes
                        const likeCount = this.querySelector('.like-count');
                        if (likeCount && data.like_count !== undefined) {
                            likeCount.textContent = data.like_count;
                        }
                        // Changer l'icône pour indiquer l'état du like
                        const icon = this.querySelector('i');
                        if (icon) {
                            if (data.liked) {
                                icon.className = 'ri-heart-3-fill text-red-500';
                                this.classList.add('liked');
                            } else {
                                icon.className = 'ri-heart-3-line';
                                this.classList.remove('liked');
                            }
                        }
                    } else {
                        Utils.showMessage(data.message || 'Erreur lors du like');
                    }
                } catch (err) {
                    console.error('Erreur lors du like:', err);
                    Utils.showMessage('Erreur lors du like');
                }
            });
        });
    }
};

// media.js - Gestion des publications média
const Media = {
    init: () => {
        Media.setupMediaUpload();
    },

    setupMediaUpload: () => {
        const previewContainer = document.getElementById('preview-container');
        const postButton = document.getElementById('post-button');
        const imageUpload = document.getElementById('image-upload');
        const videoUpload = document.getElementById('video-upload');

        if (!previewContainer || !postButton) return;

        if (imageUpload) imageUpload.addEventListener('change', Media.handleImageUpload);
        if (videoUpload) videoUpload.addEventListener('change', Media.handleVideoUpload);

        postButton.addEventListener('click', Media.handlePostSubmit);
    },

    handleImageUpload: (e) => {
        const file = e.target.files[0];
        if (!file) return;

        if (!file.type.startsWith('image/')) {
            Utils.showMessage('Veuillez sélectionner une image valide');
            return Media.resetUpload(e.target);
        }

        if (file.size > 10 * 1024 * 1024) {
            Utils.showMessage('L\'image est trop volumineuse (max 10MB)');
            return Media.resetUpload(e.target);
        }

        Media.displayMediaPreview(file, 'image');
    },

    handleVideoUpload: (e) => {
        const file = e.target.files[0];
        if (!file) return;

        if (!file.type.startsWith('video/')) {
            Utils.showMessage('Veuillez sélectionner une vidéo valide');
            return Media.resetUpload(e.target);
        }

        if (file.size > 20 * 1024 * 1024) {
            Utils.showMessage('La vidéo est trop volumineuse (max 20MB)');
            return Media.resetUpload(e.target);
        }

        Media.displayMediaPreview(file, 'video');
    },

    displayMediaPreview: (file, type) => {
        const previewContainer = document.getElementById('preview-container');
        const reader = new FileReader();

        reader.onload = (e) => {
            if (previewContainer) previewContainer.innerHTML = `
                <div class="relative group">
                    ${type === 'image' 
                        ? `<img src="${e.target.result}" alt="Preview" class="w-full rounded-lg max-h-80 object-cover">`
                        : `<video src="${e.target.result}" controls class="w-full rounded-lg max-h-80 object-cover"></video>`
                    }
                    <button class="absolute top-2 right-2 bg-gray-800 bg-opacity-70 text-white p-2 rounded-full hover:bg-opacity-100">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            
            previewContainer.classList.remove('hidden');
            document.getElementById('post-button').disabled = false;
            
            previewContainer.querySelector('button').addEventListener('click', Media.removeMedia);
        };

        reader.readAsDataURL(file);
    },

    removeMedia: () => {
        const previewContainer = document.getElementById('preview-container');
        if (previewContainer) previewContainer.innerHTML = '';
        previewContainer.classList.add('hidden');
        document.getElementById('image-upload').value = '';
        document.getElementById('video-upload').value = '';
        document.getElementById('post-button').disabled = !document.getElementById('description').value.trim();
    },

    resetUpload: (input) => {
        input.value = '';
        Media.removeMedia();
    },

    handlePostSubmit: async () => {
        const description = document.getElementById('description');
        const imageUpload = document.getElementById('image-upload');
        const videoUpload = document.getElementById('video-upload');
        const postButton = document.getElementById('post-button');

        if (!description.value.trim() && !imageUpload.files[0] && !videoUpload.files[0]) {
            return Utils.showMessage('Veuillez ajouter une description ou un média');
        }

        const formData = new FormData();
        if (description.value.trim()) formData.append('description', description.value);
        if (imageUpload.files[0]) formData.append('media', imageUpload.files[0]);
        if (videoUpload.files[0]) formData.append('media', videoUpload.files[0]);

        postButton.disabled = true;
        postButton.querySelector('#button-text').textContent = 'Publication en cours...';
        postButton.querySelector('#loading-spinner').classList.remove('hidden');

        try {
            const response = await fetch("api/Posts/mediaPost.php", {
                method: "POST",
                body: formData
            });

            const data = await Utils.handleFetchError(response);
            
            Utils.showMessage(data.message, true);
            setTimeout(() => window.chargerPage("acceuil"), 2000);
        } catch (err) {
            Utils.showMessage(err.message);
        } finally {
            postButton.disabled = false;
            postButton.querySelector('#button-text').textContent = 'Publier';
            postButton.querySelector('#loading-spinner').classList.add('hidden');
        }
    }
};

// acceuil.js - Gestion de l'acceuil
const Acceuil = {
    init: () => {
        Acceuil.getPost();
        Acceuil.setupCommentButtons();
    },

    getPost: (postId = null) => {
        let endPoint = "api/acceuil/getPost.php";
        if (postId !== null) {
            endPoint = "api/acceuil/getPost.php?id=" + postId;
        }
        
        fetch(endPoint, {
            headers: { "Content-Type": "application/json" },
            method: "GET"
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            // Vérifier si c'est un message d'erreur
            if (data.message) {
                Utils.showMessage(data.message, false);
                return;
            }

            const postsContainer = document.getElementById('posts-container');
            const reelsContainer = document.getElementById('reels-container');
            
            if (postsContainer) postsContainer.innerHTML = '';
            if (reelsContainer) reelsContainer.innerHTML = '';

            // Si on a un ID, on s'attend à un seul post (objet)
            if (postId) {
                Acceuil.displaySinglePost(data, postsContainer);
            } 
            // Sinon, on s'attend à un tableau de posts
            else {
                Acceuil.displayAllPosts(data, postsContainer, reelsContainer);
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            Utils.showMessage('Erreur lors de la récupération des posts. Veuillez vous connecter.', false);
        });
    },

    displaySinglePost: (post, container) => {
        const postDetailContainer = document.createElement('div');
        postDetailContainer.className = 'post-detail';
        
        postDetailContainer.innerHTML = `
            <div class="bg-white dark:bg-[#242526] rounded-lg shadow mb-4 overflow-hidden">
                <!-- En-tête du post -->
                <div class="flex items-center justify-between p-3">
                    <div class="flex items-center gap-2">
                        <img src="${post.profil}" class="w-10 h-10 rounded-full object-cover">
                        <div>
                            <h4 class="font-semibold text-gray-800 dark:text-white">${post.firstname} ${post.lastname}</h4>
                            <span class="text-gray-500 text-xs">${post.created_at} • <i class="ri-earth-line"></i></span>
                        </div>
                    </div>
                    <button class="w-8 h-8 rounded-full hover:bg-gray-100 dark:hover:bg-[#3a3b3c] flex items-center justify-center text-gray-500">
                        <i class="ri-more-fill"></i>
                    </button>
                </div>
                
                <!-- Contenu détaillé du post -->
                <div class="px-3 pb-3">
                    <p class="text-gray-800 dark:text-white text-lg mb-4">${post.description}</p>
                    ${post.type_post === 'image' ? `
                        <img src="${post.content.replace(/^\//, '')}" class="w-full object-cover max-h-96">
                    ` : `
                        <video src="${post.content.replace(/^\//, '')}" class="w-full object-cover max-h-96" controls></video>
                    `}
                    
                    <!-- Section commentaires détaillée -->
                    <div class="mt-6">
                        <h3 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">Commentaires</h3>
                        <div id="comments-section">
                            <!-- Les commentaires seront chargés ici -->
                        </div>
                        <form id="comment-form" class="mt-4">
                            <div class="flex items-center gap-2">
                                <img src="assets/images/default-avatar.jpg" class="w-10 h-10 rounded-full object-cover">
                                <div class="flex-1 bg-[#f0f2f5] dark:bg-[#3a3b3c] rounded-full px-3 py-2">
                                    <input type="text" id="comment-content" placeholder="Écrire un commentaire..." 
                                           class="w-full bg-transparent border-none outline-none text-gray-800 dark:text-white dark:placeholder-gray-300">
                                </div>
                                <button type="submit" class="ml-2 px-3 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark">
                                    Publier
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        `;
        
        container.appendChild(postDetailContainer);
        Commentaire.init(post.id);
    },

    displayAllPosts: (posts, postsContainer, reelsContainer) => {
        const reels = posts.filter(post => post.type_post === 'video');
        const normalPosts = posts.filter(post => post.type_post === 'image');

        // Afficher les reels
        if (reels.length > 0) {
            const reelsTitle = document.createElement('div');
            reelsTitle.className = 'bg-white dark:bg-[#242526] rounded-lg shadow mb-4 p-4';
            reelsTitle.innerHTML = `
                <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">
                    Reels
                </h2>
            `;
            reelsContainer.appendChild(reelsTitle);

            reels.forEach(reel => {
                const reelElement = document.createElement('div');
                reelElement.className = 'bg-white dark:bg-[#242526] rounded-lg shadow mb-4 overflow-hidden';
                
                reelElement.innerHTML = `
                    <!-- En-tête du reel -->
                    <div class="flex items-center justify-between p-3">
                        <div class="flex items-center gap-2">
                            <img src="${reel.profil}" class="w-10 h-10 rounded-full object-cover">
                            <div>
                                <h4 class="font-semibold text-gray-800 dark:text-white">${reel.lastname} ${reel.firstname}</h4>
                                <span class="text-gray-500 text-xs">${reel.created_at} • <i class="ri-earth-line"></i></span>
                            </div>
                        </div>
                        <button class="w-8 h-8 rounded-full hover:bg-gray-100 dark:hover:bg-[#3a3b3c] flex items-center justify-center text-gray-500">
                            <i class="ri-more-fill"></i>
                        </button>
                    </div>
                    
                    <!-- Vidéo du reel -->
                    <div class="w-full relative">
                        <div class="px-3 pb-3">
                            <p class="text-gray-800 dark:text-white">${reel.description}</p>
                        </div>
                        <video src="${reel.content.replace(/^\//, '')}" class="reel-video" controls></video>
                    </div>
                    <!-- Infos likes/commentaires -->
                    <div class="flex items-center gap-4 px-4 py-1 text-gray-500 text-sm">
                        <span><i class="ri-heart-3-fill text-red-500"></i> ${reel.likes_count || 0} J'aime</span>
                        <span><i class="ri-chat-3-line"></i> ${reel.comments_count || 0} Commentaires</span>
                    </div>
                    <!-- Actions du reel -->
                    <div class="flex justify-between px-4 py-1">
                        <button class="like-button reel-actions flex items-center justify-center gap-2 py-2 rounded-lg text-gray-600 dark:text-gray-300 hover:text-primary ${reel.is_liked ? 'liked' : ''}" 
                            data-post-id="${reel.post_id}" 
                            data-user-id="${window.currentUserId || ''}">
                            <i class="${reel.is_liked ? 'ri-heart-3-fill text-red-500' : 'ri-heart-3-line'}"></i>
                            <span class="like-count">${reel.likes_count || 0}</span>
                            <span>J'aime</span>
                        </button>
                        <button class="reel-actions flex items-center justify-center gap-2 py-2 rounded-lg text-gray-600 dark:text-gray-300 hover:text-primary comment-button" data-post-id="${reel.post_id}">
                            <i class="ri-chat-3-line"></i>
                            <span>Commenter</span>
                        </button>
                        <button class="reel-actions flex items-center justify-center gap-2 py-2 rounded-lg text-gray-600 dark:text-gray-300 hover:text-primary">
                            <i class="ri-share-forward-line"></i>
                            <span>Partager</span>
                        </button>
                    </div>
                `;
                
                reelsContainer.appendChild(reelElement);
            });
        }

        // Afficher les posts normaux
        normalPosts.forEach(post => {
            const postElement = document.createElement('div');
            postElement.className = 'bg-white dark:bg-[#242526] rounded-lg shadow mb-4 overflow-hidden';
            
            postElement.innerHTML = `
                <!-- En-tête du post -->
                <div class="flex items-center justify-between p-3">
                    <div class="flex items-center gap-2">
                        <img src="${post.profil}" class="w-10 h-10 rounded-full object-cover">
                        <div>
                            <h4 class="font-semibold text-gray-800 dark:text-white">${post.firstname} ${post.lastname}</h4>
                            <span class="text-gray-500 text-xs">${post.created_at} • <i class="ri-earth-line"></i></span>
                        </div>
                    </div>
                    <button class="w-8 h-8 rounded-full hover:bg-gray-100 dark:hover:bg-[#3a3b3c] flex items-center justify-center text-gray-500">
                        <i class="ri-more-fill"></i>
                    </button>
                </div>
                <!-- Contenu du post -->
                <div class="px-3 pb-3">
                    <p class="text-gray-800 dark:text-white">${post.description}</p>
                </div>
                <!-- Image du post -->
                ${post.type_post === 'image' ? `<img src="${post.content.replace(/^\//, '')}" class="w-full object-cover max-h-96">` : ''}
                ${post.type_post === 'video' ? `<video src="${post.content.replace(/^\//, '')}" class="w-full object-cover max-h-96" controls></video>` : ''}
                <!-- Infos likes/commentaires -->
                <div class="flex items-center gap-4 px-4 py-1 text-gray-500 text-sm">
                    <span><i class="ri-heart-3-fill text-red-500"></i> ${post.likes_count || 0} J'aime</span>
                    <span><i class="ri-chat-3-line"></i> ${post.comments_count || 0} Commentaires</span>
                </div>
                <!-- Actions du post -->
                <div class="flex justify-between px-4 py-1">
                    <button class="like-button post-actions flex items-center justify-center gap-2 py-2 rounded-lg text-gray-600 dark:text-gray-300 hover:text-primary ${post.is_liked ? 'liked' : ''}" 
                        data-post-id="${post.post_id}" 
                        data-user-id="${window.currentUserId || ''}">
                        <i class="${post.is_liked ? 'ri-heart-3-fill text-red-500' : 'ri-heart-3-line'}"></i>
                        <span class="like-count">${post.likes_count || 0}</span>
                        <span>J'aime</span>
                    </button>
                    <button class="post-actions flex items-center justify-center gap-2 py-2 rounded-lg text-gray-600 dark:text-gray-300 hover:text-primary comment-button" data-post-id="${post.post_id}">
                        <i class="ri-chat-3-line"></i>
                        <span>Commenter</span>
                    </button>
                    <button class="post-actions flex items-center justify-center gap-2 py-2 rounded-lg text-gray-600 dark:text-gray-300 hover:text-primary">
                        <i class="ri-share-forward-line"></i>
                        <span>Partager</span>
                    </button>
                </div>
            `;
            
            postsContainer.appendChild(postElement);
        });

        // Initialiser les boutons de commentaire après avoir ajouté tous les posts
        Acceuil.setupCommentButtons();
        // Initialiser les boutons de like après avoir ajouté tous les posts
        Commentaire.likePost();
    },

    setupCommentButtons: () => {
        const buttons = document.querySelectorAll('.comment-button');
        buttons.forEach(button => {
            button.addEventListener('click', async (e) => {
                e.preventDefault();
                const postId = button.dataset.postId || button.dataset.post-id;
                
                if (!postId) {
                    console.error('ID du post manquant');
                    return;
                }

                // Rediriger vers la page de commentaires avec l'ID du post
                window.chargerPage(`?page=commentaire&postId=${postId}`);
            });
        });
    }
};

// friends.js - Gestion des amis
const Friends = {
    init: () => {
        Friends.loadSuggestions();
    },
    loadSuggestions: () => {
        console.log('Chargement des suggestions d\'amis');
        fetch('api/friends/suggestions.php')
            .then(res => {
                console.log('Réponse reçue:', res.status);
                return res.json();
            })
            .then(data => {
                console.log('Données reçues:', data);
                if (!data.success) {
                    console.error('Erreur:', data.message);
                    const container = document.getElementById('friends-container');
                    if (container) {
                        container.innerHTML = `<div class="col-span-full text-center text-red-500">Erreur: ${data.message}</div>`;
                    }
                    return;
                }
                
                const container = document.getElementById('friends-container');
                if (!container) return;
                
                container.innerHTML = '';
                
                if (data.suggestions.length === 0) {
                    container.innerHTML = '<div class="col-span-full text-center text-gray-500 dark:text-gray-400 py-8">Aucune suggestion pour le moment</div>';
                    return;
                }
                
                data.suggestions.forEach(friend => {
                    const el = document.createElement('div');
                    el.className = 'bg-gray-50 dark:bg-gray-700 rounded-lg p-4 shadow';
                    el.innerHTML = `
                        <div class="flex flex-col items-center">
                            <img src="${friend.profil}" alt="${friend.firstname} ${friend.lastname}" class="w-20 h-20 rounded-full mb-3 object-cover">
                            <h3 class="font-semibold text-gray-800 dark:text-white">${friend.firstname} ${friend.lastname}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">Utilisateur Facebook</p>
                            <div class="flex gap-2 w-full">
                                <button class="add-friend-btn flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-1.5 px-4 rounded-md text-sm transition-colors" data-id="${friend.user_id}">
                                    <i class="ri-user-add-line mr-1"></i> Ajouter
                                </button>
                                <button class="remove-suggestion-btn flex-1 bg-gray-200 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-800 dark:text-white font-medium py-1.5 px-4 rounded-md text-sm transition-colors" data-id="${friend.user_id}">
                                    <i class="ri-close-line mr-1"></i> Supprimer
                                </button>
                            </div>
                        </div>
                    `;
                    container.appendChild(el);
                });
                
                // Ajout des listeners pour les boutons
                container.querySelectorAll('.add-friend-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        Friends.addFriend(this.dataset.id);
                    });
                });
                
                container.querySelectorAll('.remove-suggestion-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        Friends.removeSuggestion(this.dataset.id);
                    });
                });
            })
            .catch(err => {
                console.error('Erreur lors du chargement des suggestions:', err);
                const container = document.getElementById('friends-container');
                if (container) {
                    container.innerHTML = '<div class="col-span-full text-center text-red-500 py-8">Erreur lors du chargement</div>';
                }
            });
    },
    addFriend: (ami_id) => {
        fetch('api/friends/add.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ ami_id })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                Utils.showMessage(data.message, true);
                // Recharger la liste après ajout
                Friends.loadSuggestions();
            } else {
                Utils.showMessage(data.message, false);
            }
        })
        .catch(err => {
            console.error('Erreur lors de l\'ajout:', err);
            Utils.showMessage('Erreur lors de l\'ajout', false);
        });
    },
    removeSuggestion: (user_id) => {
        // Pour l'instant, on peut juste masquer la suggestion
        const suggestionCard = document.querySelector(`[data-id="${user_id}"]`).closest('.bg-gray-50, .dark\\:bg-gray-700');
        if (suggestionCard) {
            suggestionCard.style.display = 'none';
        }
    },
    removeFriend: (user_id) => {
        fetch('api/friends/remove.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ user_id })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                Utils.showMessage(data.message, true);
                // Recharger la liste des amis
                Profil.loadFriends();
                // Recharger les suggestions
                Friends.loadSuggestions();
            } else {
                Utils.showMessage(data.message, false);
            }
        })
        .catch(err => {
            console.error('Erreur lors de la suppression d\'ami:', err);
            Utils.showMessage('Erreur lors de la suppression d\'ami', false);
        });
    }
};

// notifications.js - Gestion des notifications
const Notifications = {
    init: () => {
        Notifications.loadNotifications();
        Notifications.setupNotificationBadge();
        Notifications.setupFilters();
        Notifications.checkNotifications();
    },

    loadNotifications: (filter = 'all') => {
        console.log('Chargement des notifications avec filtre:', filter);
        fetch(`api/notifications/get.php?filter=${filter}`)
            .then(res => {
                console.log('Réponse reçue:', res.status);
                return res.json();
            })
            .then(data => {
                console.log('Données reçues:', data);
                if (!data.success) {
                    console.error('Erreur:', data.message);
                    const container = document.getElementById('notifications-container');
                    if (container) {
                        container.innerHTML = `<div class="p-8 text-center text-red-500">Erreur: ${data.message}</div>`;
                    }
                    return;
                }
                
                const container = document.getElementById('notifications-container');
                if (!container) return;
                
                container.innerHTML = '';
                
                if (data.notifications.length === 0) {
                    container.innerHTML = '<div class="p-8 text-center text-gray-500 dark:text-gray-400">Aucune notification</div>';
                    return;
                }
                
                data.notifications.forEach(notification => {
                    const el = document.createElement('div');
                    el.className = `p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors relative ${!notification.is_read ? 'bg-blue-50 dark:bg-blue-900/20' : ''}`;
                    el.dataset.notificationId = notification.id;
                    
                    const timeAgo = Notifications.getTimeAgo(notification.created_at);
                    const notificationIcon = Notifications.getNotificationIcon(notification.type);
                    
                    el.innerHTML = `
                        <div class="flex items-start">
                            <div class="relative">
                                <img src="${notification.from_user_avatar.replace(/^\//, '') || 'assets/profil/1.jpg'}" alt="Profil" class="w-10 h-10 rounded-full mr-3 object-cover">
                                ${!notification.is_read ? '<div class="absolute -top-1 -right-1 w-3 h-3 bg-blue-500 rounded-full border-2 border-white dark:border-gray-800"></div>' : ''}
                                <div class="absolute -bottom-1 -right-1 bg-gray-100 dark:bg-gray-700 p-1 rounded-full">
                                    ${notificationIcon}
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-800 dark:text-white">
                                    ${notification.content}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">${timeAgo}</p>
                                ${notification.type === 'friend_request' ? `
                                    <div class="flex gap-2 mt-2">
                                        <button class="accept-friend-btn px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-md transition-colors" data-user-id="${notification.from_user_id}">
                                            Confirmer
                                        </button>
                                        <button class="decline-friend-btn px-3 py-1 bg-gray-200 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-800 dark:text-white text-xs font-medium rounded-md transition-colors" data-user-id="${notification.from_user_id}">
                                            Supprimer
                                        </button>
                                    </div>
                                ` : ''}
                            </div>
                            ${notification.post_content ? `
                                <div class="w-16 h-10 bg-gray-100 dark:bg-gray-600 rounded-md overflow-hidden ml-2">
                                    ${notification.post_type === 'image' ? 
                                        `<img src="${notification.post_content.replace(/^\//, '')}" alt="Miniature" class="w-full h-full object-cover">` :
                                        `<video src="${notification.post_content.replace(/^\//, '')}" class="w-full h-full object-cover"></video>`
                                    }
                                </div>
                            ` : ''}
                        </div>
                    `;
                    
                    container.appendChild(el);
                });
                
                // Ajouter les listeners pour les boutons
                Notifications.setupNotificationListeners();
                
                // Mettre à jour le badge
                Notifications.updateNotificationBadge(data.unread_count);
            })
            .catch(err => {
                console.error('Erreur lors du chargement des notifications:', err);
                const container = document.getElementById('notifications-container');
                if (container) {
                    container.innerHTML = '<div class="p-8 text-center text-red-500">Erreur lors du chargement</div>';
                }
            });
    },

    setupNotificationListeners: () => {
        // Marquer comme lu en cliquant sur une notification
        document.querySelectorAll('#notifications-container > div').forEach(notification => {
            notification.addEventListener('click', function() {
                const notificationId = this.dataset.notificationId;
                if (notificationId) {
                    Notifications.markAsRead(notificationId);
                }
            });
        });
        
        // Boutons d'acceptation/refus des demandes d'amitié
        document.querySelectorAll('.accept-friend-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const userId = this.dataset.userId;
                Notifications.respondToFriendRequest(userId, 'accept');
            });
        });
        
        document.querySelectorAll('.decline-friend-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const userId = this.dataset.userId;
                Notifications.respondToFriendRequest(userId, 'decline');
            });
        });
    },

    setupFilters: () => {
        const allBtn = document.querySelector('button');
        const unreadBtn = document.querySelectorAll('button')[1];
        
        if (allBtn && allBtn.textContent.includes('Toutes')) {
            allBtn.addEventListener('click', () => {
                Notifications.loadNotifications('all');
                allBtn.className = 'px-4 py-2 font-medium text-blue-600 dark:text-blue-400 border-b-2 border-blue-600 dark:border-blue-400';
                if (unreadBtn) {
                    unreadBtn.className = 'px-4 py-2 font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300';
                }
            });
        }
        
        if (unreadBtn && unreadBtn.textContent.includes('Non lues')) {
            unreadBtn.addEventListener('click', () => {
                Notifications.loadNotifications('unread');
                unreadBtn.className = 'px-4 py-2 font-medium text-blue-600 dark:text-blue-400 border-b-2 border-blue-600 dark:border-blue-400';
                if (allBtn) {
                    allBtn.className = 'px-4 py-2 font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300';
                }
            });
        }
    },

    setupNotificationBadge: () => {
        // Créer ou mettre à jour le badge de notifications
        const notificationBtns = document.querySelectorAll('.notification-btn');
        
        notificationBtns.forEach(btn => {
            let badge = btn.querySelector('#notification-badge');
            if (!badge) {
                badge = document.createElement('div');
                badge.id = 'notification-badge';
                badge.className = 'absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center hidden';
                btn.style.position = 'relative';
                btn.appendChild(badge);
            }
        });
    },

    updateNotificationBadge: (count = null) => {
        // Si aucun nombre n'est fourni, récupérer le nombre de notifications non lues
        if (count === null) {
            fetch('api/notifications/get.php?filter=unread')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        count = data.unread_count;
                        Notifications._updateBadge(count);
                    }
                })
                .catch(error => {
                    console.error('Erreur lors de la récupération du nombre de notifications:', error);
                });
        } else {
            Notifications._updateBadge(count);
        }
    },

    _updateBadge: (count) => {
        const badges = document.querySelectorAll('#notification-badge');
        badges.forEach(badge => {
            if (count > 0) {
                badge.textContent = count > 99 ? '99+' : count;
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }
        });
    },

    markAsRead: (notificationId) => {
        fetch('api/notifications/mark_read.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ notification_id: notificationId })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Mettre à jour l'apparence de la notification
                const notification = document.querySelector(`[data-notification-id="${notificationId}"]`);
                if (notification) {
                    notification.classList.remove('bg-blue-50', 'dark:bg-blue-900/20');
                    const unreadDot = notification.querySelector('.absolute.-top-1.-right-1');
                    if (unreadDot) unreadDot.remove();
                }
            }
        })
        .catch(err => console.error('Erreur lors du marquage comme lu:', err));
    },

    respondToFriendRequest: (userId, action) => {
        fetch('api/friends/respond.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ 
                request_user_id: userId, 
                action: action 
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                Utils.showMessage(data.message, true);
                // Recharger les notifications
                Notifications.loadNotifications();
            } else {
                Utils.showMessage(data.message, false);
            }
        })
        .catch(err => {
            console.error('Erreur lors de la réponse:', err);
            Utils.showMessage('Erreur lors de la réponse', false);
        });
    },

    getTimeAgo: (dateString) => {
        const date = new Date(dateString);
        const now = new Date();
        const diffInSeconds = Math.floor((now - date) / 1000);
        
        if (diffInSeconds < 60) return 'À l\'instant';
        if (diffInSeconds < 3600) return `Il y a ${Math.floor(diffInSeconds / 60)} min`;
        if (diffInSeconds < 86400) return `Il y a ${Math.floor(diffInSeconds / 3600)}h`;
        if (diffInSeconds < 2592000) return `Il y a ${Math.floor(diffInSeconds / 86400)}j`;
        
        return date.toLocaleDateString();
    },

    getNotificationIcon: (type) => {
        switch (type) {
            case 'friend_request':
                return '<i class="ri-user-add-line text-blue-500 text-xs"></i>';
            case 'friend_accepted':
                return '<i class="ri-user-check-line text-green-500 text-xs"></i>';
            case 'like':
                return '<i class="ri-heart-3-fill text-red-500 text-xs"></i>';
            case 'comment':
                return '<i class="ri-chat-3-line text-blue-500 text-xs"></i>';
            case 'mention':
                return '<i class="ri-at-line text-purple-500 text-xs"></i>';
            default:
                return '<i class="ri-notification-3-line text-gray-500 text-xs"></i>';
        }
    },

    checkNotifications: () => {
        Notifications.updateNotificationBadge();
        setTimeout(Notifications.checkNotifications, 60000); // Vérifier toutes les minutes
    },
};

// app.js - Gestion principale de l'application
const App = {
    init: () => {
        Utils.attachSPALinks();
        window.addEventListener('popstate', App.handlePopState);
        App.loadInitialPage();
        
        // Ajouter un listener pour les changements de contenu
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.type === 'childList') {
                    // Recharger les styles après les changements de DOM
                    setTimeout(() => {
                        App.reloadStyles();
                    }, 50);
                }
            });
        });
        
        // Observer les changements dans le contenu principal
        const content = document.getElementById('content');
        if (content) {
            observer.observe(content, { childList: true, subtree: true });
        }
    },

    loadInitialPage: () => {
        const urlParams = new URLSearchParams(window.location.search);
        const page = urlParams.get('page') || 'acceuil';
        App.chargerPage(page, false);
    },

    chargerPage: async (page, addHistory = true) => {
        // Extraire les paramètres de l'URL
        const urlParams = new URLSearchParams(page);
        let pageName = urlParams.get('page') || page;
        
        if (!pageName) pageName = "acceuil";
        
        try {
            // Préparer les paramètres pour la requête
            const params = new URLSearchParams();
            params.append('page', pageName);
            
            // Ajouter les autres paramètres
            for (const [key, value] of urlParams.entries()) {
                if (key !== 'page') {
                    params.append(key, value);
                }
            }
            
            const response = await fetch(`route.php?${params.toString()}`, { 
                headers: { "X-Requested-With": "XMLHttpRequest" } 
            });
            
            if (!response.ok) {
                const text = await response.text();
                console.error('Erreur de chargement:', response.status, text);
                throw new Error("Erreur de chargement");
            }
            
            const content = document.getElementById('content');
            content.innerHTML = await response.text();
            
            if (addHistory) {
                history.pushState({ page }, "", `?${params.toString()}`);
            }
            
            // Attendre que le DOM soit mis à jour
            await new Promise(resolve => setTimeout(resolve, 100));
            
            // Initialiser les fonctionnalités spécifiques à la page
            App.setupPageSpecificFeatures(pageName);
            
            // Recharger les styles si nécessaire
            App.reloadStyles();
            
        } catch (err) {
            console.error(err);
            document.getElementById('content').innerHTML = "<p>Erreur de chargement</p>";
        }
    },

    handlePopState: (e) => {
        const page = (e.state && e.state.page) ? e.state.page : "acceuil";
        App.chargerPage(page, false);
    },

    reloadStyles: () => {
        // Forcer le reflow pour s'assurer que les styles sont appliqués
        document.body.offsetHeight;
        
        // Recharger les styles CSS si nécessaire
        const styleSheets = document.styleSheets;
        for (let i = 0; i < styleSheets.length; i++) {
            try {
                const rules = styleSheets[i].cssRules || styleSheets[i].rules;
                if (rules && rules.length > 0) {
                    styleSheets[i].disabled = false;
                }
            } catch (e) {
                // Ignorer les erreurs CORS
            }
        }
        
        // Appliquer les classes Tailwind manquantes
        const elements = document.querySelectorAll('[class*="bg-"], [class*="text-"], [class*="border-"], [class*="rounded-"]');
        elements.forEach(element => {
            const classList = typeof element.className === 'string' ? element.className.split(' ') : [];
            classList.forEach(className => {
                if (className.includes('bg-') || className.includes('text-') || className.includes('border-') || className.includes('rounded-')) {
                    element.classList.add(className);
                }
            });
        });
    },

    setupPageSpecificFeatures: (page) => {
        console.log('Initialisation des fonctionnalités pour la page:', page);
        
        switch(page) {
            case 'login':
                Auth.attachLoginListener();
                Auth.attachLoginUIHelpers();
                break;
            case 'signup':
                Auth.attachSignupListener();
                break;
            case 'confirm':
            case 'confirmPass':
                OTP.init(page === 'confirmPass' ? 'email' : 'signup');
                break;
            case 'mediaPost':
                Media.init();
                break;
            case 'insertEmail':
                Auth.attachSendEmailListener();
                break;
            case 'editPassword':
                Auth.attachEditPasswordListener();
                break;
            case 'acceuil':
                Acceuil.init();
                break;
            case 'ajoutAmis':
                Friends.init();
                break;
            case 'amis':
                // Initialiser la page des amis si elle existe
                if (typeof FriendsPage !== 'undefined') {
                    new FriendsPage();
                }
                break;
            case 'notification':
            case 'notifications':
                Notifications.init();
                break;
            case 'commentaire':
                const urlParams = new URLSearchParams(window.location.search);
                const postId = urlParams.get('postId');
                if (postId) {
                    Commentaire.loadComments(postId);
                    Commentaire.setupCommentForm();
                }
                break;
            case 'messagerie':
                // La messagerie est gérée directement dans messagerie.php
                // Mais on peut initialiser des fonctionnalités supplémentaires ici
                initMessagerie();
                break;
            case 'profil':
                // Initialiser le profil avec un délai pour s'assurer que le DOM est prêt
                setTimeout(() => {
                    Profil.init();
                    initCoverEditModal();
                    initProfilEditModal();
                    // Ajoute un log pour debug
                    console.log('Tentative attachement bouton edit-infos-btn');
                    const btn_infos = document.getElementById('edit-infos-btn');
                    if (btn_infos) {
                        btn_infos.addEventListener('click', function(e) {
                            e.preventDefault();
                            window.chargerPage('profil_edit', true);
                        });
                    } else {
                        console.log('Bouton edit-infos-btn introuvable');
                    }
                }, 200);
                break;
            case 'profil_edit':
                initProfilEditForm();
                break;
            case 'update':
                Account.init();
                break;
            default:
                console.log('Page non reconnue:', page);
                break;
        }
        
        // Réattacher les liens SPA après chaque changement de page
        Utils.attachSPALinks();
    }
};

// Recherche dynamique sur la page notFound
const NotFoundSearch = {
    init: () => {
        const input = document.querySelector('input[placeholder^="Rechercher"]');
        if (!input) return;
        const resultsDiv = document.createElement('div');
        resultsDiv.id = 'search-results';
        resultsDiv.className = 'mt-4 space-y-2';
        input.parentNode.parentNode.appendChild(resultsDiv);

        let lastValue = '';
        input.addEventListener('input', async (e) => {
            const keyword = e.target.value.trim();
            if (keyword.length < 2) {
                resultsDiv.innerHTML = '';
                return;
            }
            if (keyword === lastValue) return;
            lastValue = keyword;
            resultsDiv.innerHTML = '<div class="text-gray-400 text-sm">Recherche...</div>';
            try {
                const response = await fetch('api/search.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ keyword })
                });
                const data = await response.json();
                if (!data.success) {
                    resultsDiv.innerHTML = `<div class='text-red-500 text-sm'>${data.message || 'Aucun résultat.'}</div>`;
                    return;
                }
                let html = '';
                if (data.results.users.length > 0) {
                    html += '<div class="font-semibold text-gray-700 dark:text-white mb-1">Utilisateurs</div>';
                    data.results.users.forEach(u => {
                        html += `<a href="?page=profil&user_id=${u.user_id}" class="flex items-center gap-2 p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <img src="${u.profil}" class="w-8 h-8 rounded-full object-cover">
                            <span class="text-gray-800 dark:text-white">${u.firstname} ${u.lastname}</span>
                        </a>`;
                    });
                }
                if (data.results.posts.length > 0) {
                    html += '<div class="font-semibold text-gray-700 dark:text-white mt-2 mb-1">Posts</div>';
                    data.results.posts.forEach(p => {
                        html += `<a href="?page=commentaire&postId=${p.post_id}" class="block p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <span class="text-gray-800 dark:text-white">${p.description}</span>
                            ${p.type_post === 'image' ? `<img src='${p.content}' class='w-16 h-16 object-cover rounded mt-1'/>` : ''}
                            ${p.type_post === 'video' ? `<video src='${p.content}' class='w-16 h-16 object-cover rounded mt-1' controls></video>` : ''}
                        </a>`;
                    });
                }
                if (!html) html = '<div class="text-gray-400 text-sm">Aucun résultat.</div>';
                resultsDiv.innerHTML = html;
            } catch (err) {
                resultsDiv.innerHTML = `<div class='text-red-500 text-sm'>Erreur lors de la recherche</div>`;
            }
        });
    }
};
// Initialiser la recherche sur la page notFound
if (window.location.search.includes('notFound')) {
    document.addEventListener('DOMContentLoaded', NotFoundSearch.init);
}

// Initialisation de l'application
document.addEventListener("DOMContentLoaded", App.init);
window.chargerPage = App.chargerPage;

const Profil = {
    init: function() {
        // Vérifier s'il y a un user_id dans l'URL
        const urlParams = new URLSearchParams(window.location.search);
        const userId = urlParams.get('user_id');
        
        // Choisir l'API appropriée
        const apiUrl = userId ? `api/profil/getUser.php?user_id=${userId}` : 'api/profil/get.php';
        
        fetch(apiUrl)
            .then(res => res.json())
            .then(data => {
                if (!data.success) {
                    Utils.showMessage(data.message || "Erreur lors du chargement du profil");
                    return;
                }
                Profil.render(data);

                // Charger les publications, photos et vidéos
                Profil.loadPosts(userId);
                Profil.loadPhotos(userId);
                Profil.loadVideos(userId);
            })
            .catch(() => {
                Utils.showMessage("Erreur lors du chargement du profil");
            });
    },

    render: function(data) {
        // Photo de profil
        document.querySelectorAll('.profile-photo img').forEach(img => {
            img.src = data.user.profil || 'assets/images/default-avatar.jpg';
        });

        // Couverture
        const cover = document.querySelector('.cover-photo img');
        if (cover) cover.src = data.user.couverture || 'assets/images/default-cover.jpg';

        // Nom complet
        const name = document.querySelector('h1.text-2xl');
        if (name) name.textContent = data.user.firstname + ' ' + data.user.lastname;

        // Bio
        const bio = document.querySelector('.bio-profil');
        if (bio) bio.textContent = data.infos.bio || 'À compléter';

        // Site web
        const website = document.querySelector('.website-profil');
        if (website) {
            website.textContent = data.infos.website || 'À compléter';
            if (data.infos.website && data.infos.website !== 'À compléter') {
                website.href = data.infos.website;
            }
        }

        // Localisation
        const location = document.querySelector('.location-profil');
        if (location) location.textContent = data.infos.location || 'À compléter';

        // Date d'inscription
        const joined = document.querySelector('.joined-profil');
        if (joined && data.user.created_at) {
            const date = new Date(data.user.created_at);
            joined.textContent = "A rejoint en " + date.toLocaleString('fr-FR', { month: 'long', year: 'numeric' });
        }

        // Infos personnelles (job, école, etc.)
        if (data.infos) {
            Profil.setText('.job-profil', data.infos.job_title);
            Profil.setText('.company-profil', data.infos.company);
            Profil.setText('.education-profil', data.infos.education);
            Profil.setText('.hometown-profil', data.infos.hometown);
            Profil.setText('.phone-profil', data.infos.phone);
            Profil.setText('.birthdate-profil', data.infos.birth_date);
            Profil.setText('.gender-profil', data.infos.gender);
            Profil.setText('.relationship-profil', data.infos.relationship_status);
            Profil.setText('.email-profil', data.user.email || 'À compléter');
        }

        // Nombre d'amis
        const nbAmis = document.querySelector('.nb-amis-profil');
        if (nbAmis) nbAmis.textContent = data.nb_amis + " amis";

        // Miniatures amis
        const amisContainer = document.querySelector('.mini-amis-profil');
        if (amisContainer && data.friends) {
            amisContainer.innerHTML = '';
            if (data.friends.length > 0) {
                data.friends.forEach(friend => {
                    amisContainer.innerHTML += `
                        <a href="?page=profil&user_id=${friend.user_id}" class="group">
                            <img src="${friend.profil || 'assets/images/default-avatar.jpg'}" class="w-20 h-20 rounded-full object-cover">
                            <p class="text-sm font-medium text-gray-800 dark:text-white group-hover:text-primary">${friend.firstname} ${friend.lastname}</p>
                        </a>
                    `;
                });
            } else {
                amisContainer.innerHTML = '<p class="text-gray-500 text-sm">Aucun ami</p>';
            }
        }

        // Boutons d'action
        const btnEdit = document.querySelector('.profile-actions .edit-profile-btn');
        const btnAdd = document.querySelector('.profile-actions .add-friend-btn');
        const btnMessage = document.querySelector('.profile-actions .message-friend-btn');
        
        if (data.is_own_profile) {
            if (btnEdit) btnEdit.style.display = '';
            if (btnAdd) btnAdd.style.display = 'none';
            if (btnMessage) btnMessage.style.display = 'none';
        } else {
            if (btnEdit) btnEdit.style.display = 'none';
            
            // Gérer le bouton d'ajout d'ami
            if (btnAdd) {
                btnAdd.style.display = '';
                btnAdd.textContent = data.friend_status === 'accepted' ? 'Retirer des amis' :
                                     data.friend_status === 'pending' ? 'Demande envoyée' : 'Ajouter en ami';
                
                // Ajouter l'action pour ajouter/retirer un ami
                btnAdd.onclick = () => {
                    if (data.friend_status === 'accepted') {
                        // Retirer des amis
                        Friends.removeFriend(data.user.user_id);
                    } else if (!data.friend_status) {
                        // Ajouter en ami
                        Friends.addFriend(data.user.user_id);
                    }
                };
            }
            
            // Gérer le bouton message (seulement pour les amis)
            if (btnMessage) {
                if (data.friend_status === 'accepted') {
                    btnMessage.style.display = '';
                    btnMessage.onclick = () => {
                        Profil.startConversation(data.user.user_id, data.user.firstname + ' ' + data.user.lastname);
                    };
                } else {
                    btnMessage.style.display = 'none';
                }
            }
        }
    },

    setText: function(selector, value) {
        const el = document.querySelector(selector);
        if (el) {
            // Afficher la valeur même si elle est "À compléter"
            el.textContent = value || 'À compléter';
        }
    },

    renderAbout: function(data) {
        const aboutSection = document.querySelector('.about-section');
        if (!aboutSection) return;

        // Vérifie si toutes les infos sont vides
        const infos = data.infos || {};
        const hasInfos = Object.values(infos).some(val => val && val.trim && val.trim() !== '' && val !== 'À compléter');

        if (!hasInfos) {
            aboutSection.innerHTML = `
                <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">${data.user.firstname} ${data.user.lastname}</h2>
                <button class="bg-blue-600 text-white px-4 py-2 rounded mt-4 add-infos-btn">Ajouter mes informations</button>
            `;
            // Ajoute ici un eventListener sur .add-infos-btn si tu veux ouvrir un formulaire
        } else {
            // Affiche les infos comme avant (déjà géré dans Profil.render)
        }
    },

    loadPosts: function(user_id) {
        fetch('api/profil/posts.php' + (user_id ? '?user_id=' + user_id : ''))
            .then(res => res.json())
            .then(data => {
                const section = document.querySelector('.publications-section');
                if (!section) return;
                if (!data.success || !data.posts.length) {
                    section.innerHTML = "<div class='text-gray-400 text-center py-8'>Aucune publication</div>";
                    return;
                }
                section.innerHTML = data.posts.map(post => `
                    <div class="bg-white dark:bg-[#242526] rounded-lg shadow mb-4">
                        <div class="p-3 flex items-center gap-2">
                            <img src="${post.profil}" class="w-10 h-10 rounded-full object-cover">
                            <div>
                                <h4 class="font-semibold text-gray-800 dark:text-white">${post.firstname} ${post.lastname}</h4>
                                <span class="text-gray-500 text-xs">${post.created_at} • <i class="ri-earth-line"></i></span>
                            </div>
                        </div>
                        <div class="px-3 pb-3">${post.description || ''}</div>
                        ${post.type_post === 'image' ? `<img src="${post.content.replace(/^\//, '')}" class="w-full object-cover max-h-96">` : ''}
                        ${post.type_post === 'video' ? `<video src="${post.content.replace(/^\//, '')}" class="w-full object-cover max-h-96" controls></video>` : ''}
                    </div>
                `).join('');
            });
    },

    loadFriends: function(user_id) {
        fetch('api/profil/friends.php' + (user_id ? '?user_id=' + user_id : ''))
            .then(res => res.json())
            .then(data => {
                const section = document.querySelector('.friends-section');
                if (!section) return;
                if (!data.success || !data.friends.length) {
                    section.innerHTML = "<div class='text-gray-400 text-center py-8 col-span-full'>Aucun ami</div>";
                    return;
                }
                section.innerHTML = data.friends.map(friend => `
                    <a href="?page=profil&user_id=${friend.user_id}" class="flex flex-col items-center group">
                        <img src="${friend.profil || 'assets/images/default-avatar.jpg'}" class="w-20 h-20 rounded-full object-cover">
                        <span class="text-gray-800 dark:text-white group-hover:text-primary">${friend.firstname} ${friend.lastname}</span>
                    </a>
                `).join('');
            });
    },

    
    loadPhotos: function(user_id) {
        fetch('api/profil/photos.php' + (user_id ? '?user_id=' + user_id : ''))
            .then(res => res.json())
            .then(data => {
                const section = document.querySelector('.photos-section');
                if (!section) return;
                if (!data.success || !data.photos.length) {
                    section.innerHTML = "<div class='text-gray-400 text-center py-8 col-span-full'>Aucune photo</div>";
                    return;
                }
                section.innerHTML = data.photos.map(photo => `
                    <img src="${photo.content.replace(/^\//, '')}" class="w-full aspect-square object-cover rounded">
                `).join('');
            });
    },

    loadVideos: function(user_id) {
        fetch('api/profil/videos.php' + (user_id ? '?user_id=' + user_id : ''))
            .then(res => res.json())
            .then(data => {
                const section = document.querySelector('.videos-section');
                if (!section) return;
                if (!data.success || !data.videos.length) {
                    section.innerHTML = "<div class='text-gray-400 text-center py-8 col-span-full'>Aucune vidéo</div>";
                    return;
                }
                section.innerHTML = data.videos.map(video => `
                    <video src="${video.content}" class="w-full rounded" controls></video>
                `).join('');
            });
    },

    startConversation: (userId, userName) => {
        // Rediriger vers la page de messagerie avec l'ID de l'utilisateur
        window.chargerPage(`?page=messagerie&user_id=${userId}`);
    }
};

document.addEventListener('DOMContentLoaded', () => {
    Notifications.checkNotifications();
});

// Initialisation automatique si on est sur la page profil
document.addEventListener('DOMContentLoaded', () => {
    if (window.location.search.includes('page=profil')) {
        Profil.init();
    }

    Profil.loadPosts = function(user_id) {
        fetch('api/profil/posts.php' + (user_id ? '?user_id=' + user_id : ''))
            .then(res => res.json())
            .then(data => {
                const section = document.querySelector('.publications-section');
                if (!section) return;
                if (!data.success || !data.posts.length) {
                    section.innerHTML = "<div class='text-gray-400 text-center py-8'>Aucune publication</div>";
                    return;
                }
                section.innerHTML = data.posts.map(post => `
                    <div class="bg-white dark:bg-[#242526] rounded-lg shadow mb-4">
                        <div class="p-3 flex items-center gap-2">
                            <img src="${post.profil}" class="w-10 h-10 rounded-full object-cover">
                            <div>
                                <h4 class="font-semibold text-gray-800 dark:text-white">${post.firstname} ${post.lastname}</h4>
                                <span class="text-gray-500 text-xs">${post.created_at} • <i class="ri-earth-line"></i></span>
                            </div>
                        </div>
                        <div class="px-3 pb-3">${post.description || ''}</div>
                        ${post.type_post === 'image' ? `<img src="${post.content.replace(/^\//, '')}" class="w-full object-cover max-h-96">` : ''}
                        ${post.type_post === 'video' ? `<video src="${post.content.replace(/^\//, '')}" class="w-full object-cover max-h-96" controls></video>` : ''}
                    </div>
                `).join('');
            });
    };

    Profil.loadFriends = function(user_id) {
        fetch('api/profil/friends.php' + (user_id ? '?user_id=' + user_id : ''))
            .then(res => res.json())
            .then(data => {
                const section = document.querySelector('.friends-section');
                if (!section) return;
                if (!data.success || !data.friends.length) {
                    section.innerHTML = "<div class='text-gray-400 text-center py-8 col-span-full'>Aucun ami</div>";
                    return;
                }
                section.innerHTML = data.friends.map(friend => `
                    <a href="?page=profil&user_id=${friend.user_id}" class="flex flex-col items-center group">
                        <img src="${friend.profil || 'assets/images/default-avatar.jpg'}" class="w-20 h-20 rounded-full object-cover">
                        <span class="text-gray-800 dark:text-white group-hover:text-primary">${friend.firstname} ${friend.lastname}</span>
                    </a>
                `).join('');
            });
    };

    Profil.loadPhotos = function(user_id) {
        fetch('api/profil/photos.php' + (user_id ? '?user_id=' + user_id : ''))
            .then(res => res.json())
            .then(data => {
                const section = document.querySelector('.photos-section');
                if (!section) return;
                if (!data.success || !data.photos.length) {
                    section.innerHTML = "<div class='text-gray-400 text-center py-8 col-span-full'>Aucune photo</div>";
                    return;
                }
                section.innerHTML = data.photos.map(photo => `
                    <img src="${photo.content.replace(/^\//, '')}" class="w-full aspect-square object-cover rounded">
                `).join('');
            });
    };

    Profil.loadVideos = function(user_id) {
        fetch('api/profil/videos.php' + (user_id ? '?user_id=' + user_id : ''))
            .then(res => res.json())
            .then(data => {
                const section = document.querySelector('.videos-section');
                if (!section) return;
                if (!data.success || !data.videos.length) {
                    section.innerHTML = "<div class='text-gray-400 text-center py-8 col-span-full'>Aucune vidéo</div>";
                    return;
                }
                section.innerHTML = data.videos.map(video => `
                    <video src="${video.content}" class="w-full rounded" controls></video>
                `).join('');
            });
    };
});

// Messagerie.js - Gestion complète de la messagerie (conversations, messages, polling) en JS natif sans classe
function initMessagerie() {
    if (!document.getElementById('messages-container')) return;

    let currentConversation = null;
    let pollingInterval = null;
    const currentUserId = window.currentUserId || 1;

    function showMessage(message, isSuccess = false, duration = 4000) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `fixed top-10 right-3 max-w-xs w-full p-4 rounded shadow-lg z-50 ${
            isSuccess 
                ? 'bg-green-100 dark:bg-green-900 border-l-4 border-green-500 text-green-700 dark:text-green-100'
                : 'bg-red-100 dark:bg-red-900 border-l-4 border-red-500 text-red-700 dark:text-red-100'
        }`;
        messageDiv.innerHTML = `
            <div class="flex justify-between items-center">
                <span>${message}</span>
                <button class="ml-4" onclick="this.parentElement.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        document.body.appendChild(messageDiv);
        setTimeout(() => messageDiv.remove(), duration);
    }

    function getTimeAgo(dateString) {
        if (!dateString) return '';
        const date = new Date(dateString);
        const now = new Date();
        const diffInSeconds = Math.floor((now - date) / 1000);
        if (diffInSeconds < 60) return 'À l\'instant';
        if (diffInSeconds < 3600) return `Il y a ${Math.floor(diffInSeconds / 60)} min`;
        if (diffInSeconds < 86400) return `Il y a ${Math.floor(diffInSeconds / 3600)}h`;
        if (diffInSeconds < 2592000) return `Il y a ${Math.floor(diffInSeconds / 86400)}j`;
        return date.toLocaleDateString();
    }

    function loadConversations() {
        fetch('api/message/conversations.php')
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    renderConversations(data.conversations);
                } else {
                    showMessage('Erreur lors du chargement des conversations');
                }
            })
            .catch(() => showMessage('Erreur de connexion'));
    }

    function renderConversations(conversations) {
        const container = document.getElementById('conversations-list');
        if (!container) return;
        if (conversations.length === 0) {
            container.innerHTML = `
                <div class="p-4 text-center text-gray-500 dark:text-gray-400">
                    <i class="ri-message-3-line text-2xl mb-2"></i>
                    <p>Aucune conversation</p>
                </div>
            `;
            return;
        }
        container.innerHTML = conversations.map(conv => {
            const otherUser = conv.other_user;
            const lastMessage = conv.last_message || 'Aucun message';
            const timeAgo = getTimeAgo(conv.last_message_time);
            const unreadBadge = conv.unread_count > 0 ? `<div class="ml-2 w-2 h-2 bg-blue-500 rounded-full"></div>` : '';
            return `
                <div class="conversation-item p-3 flex items-center border-b border-gray-200 dark:border-gray-700 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" 
                     data-conversation-id="${conv.id}" 
                     data-other-user='${JSON.stringify(otherUser)}'>
                    <div class="relative mr-3">
                        <img src="${otherUser?.profil || 'assets/profil/1.jpg'}" alt="Profil" class="w-12 h-12 rounded-full object-cover">
                        <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white dark:border-gray-800"></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between">
                            <h3 class="font-semibold text-gray-800 dark:text-white truncate">${otherUser?.firstname} ${otherUser?.lastname}</h3>
                            <span class="text-xs text-gray-500 dark:text-gray-400">${timeAgo}</span>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-300 truncate">${lastMessage}</p>
                    </div>
                    ${unreadBadge}
                </div>
            `;
        }).join('');
        setupConversationListeners();
    }

    function setupConversationListeners() {
        document.querySelectorAll('.conversation-item').forEach(item => {
            item.addEventListener('click', function() {
                const conversationId = item.dataset.conversationId;
                const otherUser = JSON.parse(item.dataset.otherUser);
                selectConversation(conversationId, otherUser);
                document.querySelectorAll('.conversation-item').forEach(i => i.classList.remove('conversation-active'));
                item.classList.add('conversation-active');
                if (window.innerWidth < 768) {
                    document.querySelector('.conversation-list').classList.remove('active');
                    document.getElementById('message-area').classList.add('active');
                }
            });
        });
    }

    function selectConversation(conversationId, otherUser) {
        currentConversation = conversationId;
        if (pollingInterval) clearInterval(pollingInterval);
        document.getElementById('conversation-avatar').src = otherUser.profil || 'assets/profil/1.jpeg';
        document.getElementById('conversation-name').textContent = `${otherUser.firstname} ${otherUser.lastname}`;
        document.getElementById('conversation-status').textContent = 'En ligne';
        document.getElementById('message-input').disabled = false;
        loadMessages(conversationId);
        pollingInterval = setInterval(() => loadMessages(conversationId), 2000);
    }

    function loadMessages(conversationId) {
        fetch(`api/message/messages.php?conversation_id=${conversationId}`)
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    renderMessages(data.messages);
                } else {
                    showMessage('Erreur lors du chargement des messages');
                }
            })
            .catch(() => showMessage('Erreur de connexion'));
    }

    function renderMessages(messages) {
        const container = document.getElementById('messages-container');
        if (!container) return;
        if (messages.length === 0) {
            container.innerHTML = `
                <div class="flex items-center justify-center h-full">
                    <div class="text-center text-gray-500 dark:text-gray-400">
                        <i class="ri-message-3-line text-4xl mb-2"></i>
                        <p>Aucun message</p>
                    </div>
                </div>
            `;
            return;
        }
        container.innerHTML = messages.map(message => {
            const isOwnMessage = message.sender_id == currentUserId;
            const messageTime = new Date(message.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
            if (isOwnMessage) {
                return `
                    <div class="flex justify-end mb-4 animate-message-in">
                        <div class="text-right">
                            <div class="bg-blue-600 text-white rounded-lg p-3 max-w-xs md:max-w-md ml-auto">
                                <p>${message.content}</p>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">${messageTime}</p>
                        </div>
                        <img src="assets/profil/1.jpg" alt="Profil" class="w-8 h-8 rounded-full ml-2 mt-1 flex-shrink-0">
                    </div>
                `;
            } else {
                return `
                    <div class="flex mb-4 animate-message-in">
                        <img src="${message.profil || 'assets/profil/1.jpg'}" alt="Profil" class="w-8 h-8 rounded-full mr-2 mt-1 flex-shrink-0">
                        <div>
                            <div class="bg-gray-200 dark:bg-gray-600 rounded-lg p-3 max-w-xs md:max-w-md">
                                <p class="text-gray-800 dark:text-white">${message.content}</p>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">${messageTime}</p>
                        </div>
                    </div>
                `;
            }
        }).join('');
        container.scrollTop = container.scrollHeight;
    }

    function sendMessage() {
        const input = document.getElementById('message-input');
        const message = input.value.trim();
        if (!message || !currentConversation) return;
        fetch('api/message/messages.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                conversation_id: currentConversation,
                content: message,
                sender_id: currentUserId
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                input.value = '';
                loadMessages(currentConversation);
            } else {
                showMessage(data.message || 'Erreur lors de l\'envoi');
            }
        })
        .catch(() => showMessage('Erreur de connexion'));
    }

    // Listeners
    const btn = document.getElementById('send-message');
    const input = document.getElementById('message-input');
    if (btn) btn.addEventListener('click', sendMessage);
    if (input) input.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') sendMessage();
    });
    // Navigation mobile
    const toggleConversationList = document.getElementById('toggle-conversation-list');
    const toggleMessageArea = document.getElementById('toggle-message-area');
    const conversationList = document.querySelector('.conversation-list');
    const messageArea = document.getElementById('message-area');
    if (toggleConversationList && toggleMessageArea) {
        toggleConversationList.addEventListener('click', function() {
            conversationList.classList.add('active');
            messageArea.classList.remove('active');
        });
        toggleMessageArea.addEventListener('click', function() {
            conversationList.classList.remove('active');
            messageArea.classList.add('active');
        });
    }

    // Si un user_id est passé dans l'URL, démarrer la conversation
    const urlParams = new URLSearchParams(window.location.search);
    const userId = urlParams.get('user_id');
    if (userId) {
        // Créer une conversation si besoin puis la sélectionner
        fetch('api/message/conversations.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ other_user_id: userId })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                loadConversations();
                setTimeout(() => {
                    const conversationItem = document.querySelector(`[data-conversation-id="${data.conversation.id}"]`);
                    if (conversationItem) conversationItem.click();
                }, 200);
            } else {
                showMessage(data.message || 'Erreur lors de la création de la conversation');
            }
        })
        .catch(() => showMessage('Erreur lors de la création de la conversation'));
    } else {
        loadConversations();
    }
}

// Place ceci à la fin de script.js (avant le dernier commentaire ou juste avant la fin du fichier)
function initCoverEditModal() {
    // Ouvre la modale au clic sur le bouton Modifier
    document.querySelector('.cover-photo button')?.addEventListener('click', function() {
        // Met à jour l'aperçu avec l'ancienne image
        const coverImg = document.querySelector('.cover-photo img');
        document.getElementById('current-cover-preview').src = coverImg ? coverImg.src : '';
        document.getElementById('modal-cover').classList.remove('hidden');
        document.getElementById('new-cover-preview-container').classList.add('hidden');
        document.getElementById('cover-file-input').value = '';
        document.getElementById('new-cover-preview').src = '';
    });

    // Ferme la modale
    document.getElementById('close-modal-cover')?.addEventListener('click', function() {
        document.getElementById('modal-cover').classList.add('hidden');
    });

    // Preview de la nouvelle image
    document.getElementById('cover-file-input')?.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('new-cover-preview').src = e.target.result;
                document.getElementById('new-cover-preview-container').classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            document.getElementById('new-cover-preview-container').classList.add('hidden');
        }
    });

    // Envoi du formulaire
    document.getElementById('save-cover-btn')?.addEventListener('click', function() {
        const fileInput = document.getElementById('cover-file-input');
        const file = fileInput.files[0];
        if (!file) {
            Utils.showMessage('Veuillez sélectionner une image');
            return;
        }
        console.log("Image capturer")
        const formData = new FormData();
        formData.append('photo', file);
        formData.append('type', 'cover');
        fetch('api/profil/update_photo.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Met à jour la photo de couverture sur la page
                document.querySelector('.cover-photo img').src = data.url;
                Utils.showMessage('Photo de couverture mise à jour', true);
                document.getElementById('modal-cover').classList.add('hidden');
            } else {
                Utils.showMessage(data.message);
            }
        });
    });
}

function initProfilEditModal() {
    const editBtn = document.getElementById('edit-profile-btn');
    if (editBtn) {
        editBtn.addEventListener('click', function() {
            console.log('Bouton Modifier le profil cliqué');
            const profilImg = document.querySelector('.profile-photo img');
            document.getElementById('current-profil-preview').src = profilImg ? profilImg.src : '';
            document.getElementById('modal-profil').classList.remove('hidden');
            document.getElementById('new-profil-preview-container').classList.add('hidden');
            document.getElementById('profil-file-input').value = '';
            document.getElementById('new-profil-preview').src = '';
        });
    }

    const closeBtn = document.getElementById('close-modal-profil');
    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            document.getElementById('modal-profil').classList.add('hidden');
        });
    }

    const fileInput = document.getElementById('profil-file-input');
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('new-profil-preview').src = e.target.result;
                    document.getElementById('new-profil-preview-container').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                document.getElementById('new-profil-preview-container').classList.add('hidden');
            }
        });
    }

    const saveBtn = document.getElementById('save-profil-btn');
    if (saveBtn) {
        saveBtn.addEventListener('click', function() {
            const fileInput = document.getElementById('profil-file-input');
            const file = fileInput.files[0];
            if (!file) {
                Utils.showMessage('Veuillez sélectionner une image');
                return;
            }
            const formData = new FormData();
            formData.append('photo', file);
            formData.append('type', 'profil');
            fetch('api/profil/update_photo.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    document.querySelector('.profile-photo img').src = data.url;
                    Utils.showMessage('Photo de profil mise à jour', true);
                    document.getElementById('modal-profil').classList.add('hidden');
                } else {
                    Utils.showMessage(data.message);
                }
            });
        });
    }

    const btn_form = document.getElementById('edit-profile-form');
    console.log('btn_form:', btn_form);
    if (btn_form) {
        btn_form.addEventListener('submit', function(e) {
            console.log('Soumission interceptée');
            e.preventDefault();
            const formData = {
                firstname: document.getElementById('firstname').value,
                lastname: document.getElementById('lastname').value,
                bio: document.getElementById('bio').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
                visibility: document.getElementById('visibility').value,
                show_email: document.getElementById('show-email').checked ? 1 : 0,
                job_title: document.getElementById('job_title').value,
                company: document.getElementById('company').value,
                education: document.getElementById('education').value,
                relationship_status: document.getElementById('relationship_status').value
            };
            fetch('api/profil/update_infos.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(formData)
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('Profil mis à jour !');
                    window.chargerPage('profil');
                } else {
                    alert(data.message || 'Erreur lors de la mise à jour');
                }
            });
        });
    }
}

function initProfilEditForm() {
    fetch('api/profil/get.php')
        .then(res => res.json())
        .then(data => {
            if (!data.success) {
                Utils.showMessage(data.message || "Erreur lors du chargement du profil");
                return;
            }
            const user = data.user;
            const infos = data.infos || {};
            document.getElementById('firstname').value = user.firstname || '';
            document.getElementById('lastname').value = user.lastname || '';
            document.getElementById('bio').value = infos.bio || '';
            document.getElementById('email').value = user.email || '';
            document.getElementById('phone').value = infos.phone || '';
            document.getElementById('visibility').value = infos.visibility || 'public';
            document.getElementById('show-email').checked = !!infos.show_email;
            document.getElementById('job_title').value = infos.job_title || '';
            document.getElementById('company').value = infos.company || '';
            document.getElementById('education').value = infos.education || '';
            document.getElementById('relationship_status').value = infos.relationship_status || 'À compléter';
        });
}

// account.js - Gestion de la mise à jour du compte
const Account = {
    init: function() {
        // Charger les infos utilisateur
        loadUserData();

        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        if (togglePassword && password) {
            togglePassword.addEventListener('click', function() {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                this.textContent = type === 'password' ? '👁️' : '🔒';
            });
        }

        // Gestion de la soumission du formulaire
        const form = document.getElementById('accountForm');
        if (form) {
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                const formData = new FormData(form);
                
                try {
                    const response = await fetch("api/update.php", {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify(Object.fromEntries(formData))
                    });
                    
                    const data = await Utils.handleFetchError(response);
                    
                    if (data.success) {
                        Utils.showMessage(data.message, true);
                        // Réinitialiser le formulaire
                        form.reset();
                        // Cacher les messages d'erreur
                        document.querySelectorAll('[id$="-error"]').forEach(el => el.classList.add('hidden'));
                    } else {
                        if (data.errors) {
                            // Afficher les erreurs spécifiques
                            data.errors.forEach(error => {
                                if (error.includes('email')) {
                                    document.getElementById('email-error').classList.remove('hidden');
                                } else if (error.includes('mot de passe')) {
                                    document.getElementById('password-error').classList.remove('hidden');
                                } else if (error.includes('correspondent')) {
                                    document.getElementById('confirm-error').classList.remove('hidden');
                                }
                            });
                        }
                        Utils.showMessage(data.message);
                    }
                } catch (err) {
                    Utils.showMessage(err.message);
                }
            });
        }
    }
};

// Initialiser Account
Account.init();

async function loadUserData() {
    console.log('Appel de loadUserData'); // Ajoute ce log
    try {
        const response = await fetch('api/get_user_info.php');
        const data = await response.json();
        console.log('Réponse API:', data);
        if (data.success) {
            document.getElementById('email').value = data.email;
        }
    } catch (error) {
        console.error('Erreur lors du chargement des données:', error);
        if (typeof Utils !== 'undefined') Utils.showMessage('Erreur lors du chargement des données', false);
    }
}

// Media upload functionality - Code optimisé
document.addEventListener('DOMContentLoaded', () => {
    // Elements DOM
    const previewContainer = document.getElementById('preview-container');
    const postButton = document.getElementById('post-button');
    const description = document.getElementById('description');
    const errorMessage = document.getElementById('error-message');
    const errorText = document.getElementById('error-text');
    const imageUpload = document.getElementById('image-upload');
    const videoUpload = document.getElementById('video-upload');
    const uploadButtons = document.querySelectorAll('.upload-button');

    // Constantes
    const MAX_FILE_SIZE = 10 * 1024 * 1024; // 10MB
    const SUCCESS_DURATION = 3000; // 3s
    const ERROR_DURATION = 5000; // 5s

    // Variables d'état
    let currentMediaType = null; // 'image' ou 'video'

    // Gestion des événements
    if (imageUpload) {
        imageUpload.addEventListener('change', handleImageUpload);
    }

    if (videoUpload) {
        videoUpload.addEventListener('change', handleVideoUpload);
    }

    uploadButtons.forEach(button => {
        button.addEventListener('click', handleUploadClick);
    });

    // Gestion de l'input description
    if (description) {
        description.addEventListener('input', () => {
            postButton.disabled = !(description.value.trim() || currentMediaType);
        });
    }

    if (postButton) {
        postButton.addEventListener('click', handlePostSubmit);
    }

    // Fonctions
    function handleImageUpload(e) {
        const file = e.target.files[0];
        
        if (!file) return;
        
        if (!file.type.startsWith('image/')) {
            showError('Veuillez sélectionner uniquement une image.');
            resetUpload(imageUpload);
            return;
        }
        
        if (file.size > MAX_FILE_SIZE) {
            showError('L\'image est trop volumineuse (max 10MB)');
            resetUpload(imageUpload);
            return;
        }
        
        handleMediaPreview(file);
    }

    function handleVideoUpload(e) {
        const file = e.target.files[0];
        
        if (!file) return;
        
        if (!file.type.startsWith('video/')) {
            showError('Veuillez sélectionner uniquement une vidéo.');
            resetUpload(videoUpload);
            return;
        }
        
        if (file.size > MAX_FILE_SIZE) {
            showError('La vidéo est trop volumineuse (max 10MB)');
            resetUpload(videoUpload);
            return;
        }
        
        handleMediaPreview(file);
    }

    function handleUploadClick(e) {
        const type = e.currentTarget.dataset.uploadType;
        if (type === 'image') {
            imageUpload.click();
        } else if (type === 'video') {
            videoUpload.click();
        }
    }

    function handleMediaPreview(file) {
        const fileType = file.type;
        const isImage = fileType.startsWith('image/');
        const isVideo = fileType.startsWith('video/');
        
        if (!isImage && !isVideo) return;
        
        const reader = new FileReader();
        
        reader.onload = (event) => {
            previewContainer.innerHTML = '';
            
            const mediaElement = isImage 
                ? createImageElement(event.target.result)
                : createVideoElement(event.target.result);
            
            currentMediaType = isImage ? 'image' : 'video';
            
            const removeBtn = createRemoveButton();
            const relativeDiv = document.createElement('div');
            relativeDiv.className = 'relative group';
            relativeDiv.appendChild(mediaElement);
            relativeDiv.appendChild(removeBtn);
            previewContainer.appendChild(relativeDiv);
            
            previewContainer.classList.remove('hidden');
            postButton.disabled = false;
            
            removeBtn.addEventListener('click', handleRemoveMedia);
        };
        
        reader.readAsDataURL(file);
    }

    function createImageElement(src) {
        const img = document.createElement('img');
        img.id = 'preview';
        img.src = src;
        img.alt = 'Preview';
        img.className = 'w-full rounded-lg max-h-80 object-cover';
        return img;
    }

    function createVideoElement(src) {
        const video = document.createElement('video');
        video.id = 'preview';
        video.src = src;
        video.controls = true;
        video.className = 'w-full rounded-lg max-h-80 object-cover';
        return video;
    }

    function createRemoveButton() {
        const btn = document.createElement('button');
        btn.id = 'remove-media';
        btn.className = 'absolute top-2 right-2 bg-gray-800 bg-opacity-70 text-white p-2 rounded-full hover:bg-opacity-100';
        btn.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        `;
        return btn;
    }

    function handleRemoveMedia() {
        previewContainer.innerHTML = '';
        previewContainer.classList.add('hidden');
        
        if (currentMediaType === 'image') {
            imageUpload.value = '';
        } else if (currentMediaType === 'video') {
            videoUpload.value = '';
        }
        
        postButton.disabled = !description.value.trim();
        currentMediaType = null;
    }

    async function handlePostSubmit() {
        // Validation
        if (!description.value.trim() && !currentMediaType) {
            showError('Veuillez ajouter une description ou un média');
            return;
        }
        
        const mediaFile = currentMediaType === 'image' 
            ? imageUpload.files[0] 
            : videoUpload.files[0];
        
        // Préparation des données
        const formData = new FormData();
        if (mediaFile) formData.append('media', mediaFile);
        formData.append('description', description.value);
        
        // UI pendant l'envoi
        postButton.disabled = true;
        const originalText = postButton.textContent;
        postButton.textContent = 'Publication en cours...';
        
        try {
            const response = await fetch("../../api/Posts/mediaPost.php", {
                method: "POST",
                body: formData
            });
            
            const data = await response.json();
            
            if (!response.ok) throw new Error(data.message || "Erreur réseau");
            
            showSuccess(data.message);
            
            // Redirection après succès
            setTimeout(() => {
                if (typeof chargerPage === 'function') {
                    chargerPage("profil");
                } else {
                    window.location.href = "../../../vues/users/profil.php";
                }
            }, SUCCESS_DURATION);
            
        } catch (err) {
            console.error("Erreur:", err);
            showError(err.message || "Une erreur inattendue s'est produite");
        } finally {
            postButton.disabled = false;
            postButton.textContent = originalText;
        }
    }

    function showError(message) {
        errorText.textContent = message;
        errorMessage.classList.remove('hidden');
        errorMessage.style.backgroundColor = '#fee2e2';
        errorMessage.style.color = '#b91c1c';
        
        setTimeout(() => {
            errorMessage.classList.add('hidden');
        }, ERROR_DURATION);
    }

    function showSuccess(message) {
        errorText.textContent = message;
        errorMessage.classList.remove('hidden');
        errorMessage.style.backgroundColor = '#d1fae5';
        errorMessage.style.color = '#065f46';
    }

    function resetUpload(uploadElement) {
        uploadElement.value = '';
        previewContainer.innerHTML = '';
        previewContainer.classList.add('hidden');
        postButton.disabled = !description.value.trim();
        currentMediaType = null;
    }
});
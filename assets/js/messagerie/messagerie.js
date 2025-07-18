// Messagerie.js - Gestion complète de la messagerie (conversations, messages, polling) en JS natif sans classe

(function() {
    // Utilitaire pour afficher les messages d'erreur ou de succès
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

    document.addEventListener('DOMContentLoaded', function() {
        if (!document.getElementById('messages-container')) return;

        let currentConversation = null;
        let pollingInterval = null;
        const currentUserId = window.currentUserId || 1;

        // Affichage initial : afficher le message d'accueil si présent
        const messagesContainer = document.getElementById('messages-container');
        if (messagesContainer) {
            const welcome = document.getElementById('welcome-message');
            if (welcome) welcome.style.display = '';
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
            // Masquer le message d'accueil
            const welcome = document.getElementById('welcome-message');
            if (welcome) welcome.style.display = 'none';
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
            // Masquer le message d'accueil si présent
            const welcome = document.getElementById('welcome-message');
            if (welcome) welcome.style.display = 'none';
            if (messages.length === 0) {
                container.innerHTML = '';
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
        if (btn) {
            console.log('message-content');
            btn.addEventListener('click', function() {
                alert("erreur");
            });
        }
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
    });
})();

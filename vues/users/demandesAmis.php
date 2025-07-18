<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Demandes d'amis</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
    <link rel="stylesheet" href="../assets/css/profil.css">
    <style>
        body { background: #f0f2f5; }
        .demande-card { background: #fff; border-radius: 8px; box-shadow: 0 2px 8px #0001; padding: 1rem; margin-bottom: 1rem; display: flex; align-items: center; }
        .demande-card img { width: 56px; height: 56px; border-radius: 50%; object-fit: cover; margin-right: 1rem; }
        .demande-actions button { margin-right: 0.5rem; }
    </style>
</head>
<body>
    <div class="max-w-xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Demandes d'amis reçues</h1>
        <div id="demandes-list">
            <div class="text-gray-500">Chargement...</div>
        </div>
    </div>
    <script>
    async function chargerDemandes() {
        const container = document.getElementById('demandes-list');
        container.innerHTML = '<div class="text-gray-500">Chargement...</div>';
        try {
            const res = await fetch('api/friends/demandes.php');
            const data = await res.json();
            if (!data.success) {
                container.innerHTML = '<div class="text-red-500">'+(data.message||'Erreur de chargement')+'</div>';
                return;
            }
            if (!data.demandes.length) {
                container.innerHTML = '<div class="text-gray-500">Aucune demande en attente</div>';
                return;
            }
            container.innerHTML = data.demandes.map(d => `
                <div class="demande-card" data-user="${d.user_id}">
                    <img src="${d.profil||'assets/images/default-avatar.jpg'}" alt="${d.firstname} ${d.lastname}">
                    <div class="flex-1">
                        <div class="font-semibold">${d.firstname} ${d.lastname}</div>
                        <div class="text-xs text-gray-500">Demande envoyée le ${new Date(d.created_at).toLocaleDateString()}</div>
                    </div>
                    <div class="demande-actions">
                        <button class="accepter-btn" data-user="${d.user_id}"><i class="ri-user-add-line"></i> Accepter</button>
                        <button class="refuser-btn" data-user="${d.user_id}"><i class="ri-close-line"></i> Refuser</button>
                    </div>
                </div>
            `).join('');
            brancherBoutons();
        } catch (e) {
            container.innerHTML = '<div class="text-red-500">Erreur de connexion</div>';
        }
    }

    function brancherBoutons() {
        document.querySelectorAll('.accepter-btn').forEach(btn => {
            btn.onclick = async function() {
                const userId = this.getAttribute('data-user');
                await repondreDemande(userId, 'accept');
            };
        });
        document.querySelectorAll('.refuser-btn').forEach(btn => {
            btn.onclick = async function() {
                const userId = this.getAttribute('data-user');
                await repondreDemande(userId, 'decline');
            };
        });
    }

    async function repondreDemande(userId, action) {
        const card = document.querySelector('.demande-card[data-user="'+userId+'"]');
        if (card) card.style.opacity = 0.5;
        try {
            const res = await fetch('api/friends/respond.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ request_user_id: userId, action })
            });
            const data = await res.json();
            if (data.success) {
                if (card) card.remove();
                // Si plus de demandes, afficher le message
                if (!document.querySelector('.demande-card')) {
                    document.getElementById('demandes-list').innerHTML = '<div class="text-gray-500">Aucune demande en attente</div>';
                }
            } else {
                if (card) card.style.opacity = 1;
                alert(data.message || 'Erreur lors de la réponse');
            }
        } catch (e) {
            if (card) card.style.opacity = 1;
            alert('Erreur de connexion');
        }
    }

    document.addEventListener('DOMContentLoaded', chargerDemandes);
    </script>
</body>
</html> 
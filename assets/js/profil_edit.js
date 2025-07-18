// assets/js/profil_edit.js

function initProfilEditForm() {
    const form = document.getElementById('edit-profile-form');
    if (!form) return;

    // Charger les infos utilisateur (optionnel, si besoin)
    fetch('api/profil/get.php')
        .then(res => res.json())
        .then(data => {
            if (!data.success) {
                alert(data.message || "Erreur lors du chargement du profil");
                return;
            }
            const user = data.user;
            const infos = data.infos || {};
            const firstnameInput = document.getElementById('firstname');
            if (firstnameInput) firstnameInput.value = user.firstname || '';
            document.getElementById('lastname').value = user.lastname || '';
            document.getElementById('bio').value = infos.bio || '';
            document.getElementById('email').value = user.email || '';
            document.getElementById('phone').value = infos.phone || '';
            document.getElementById('visibility').value = infos.visibility || 'public';
            document.getElementById('show-email').checked = !!infos.show_email;
            if (document.getElementById('website')) {
                document.getElementById('website').value = infos.website || '';
            }
            if (document.getElementById('location')) {
                document.getElementById('location').value = infos.location || '';
            }
            if (document.getElementById('hometown')) {
                document.getElementById('hometown').value = infos.hometown || '';
            }
            if (document.getElementById('graduation_year')) {
                document.getElementById('graduation_year').value = infos.graduation_year || '';
            }
            if (document.getElementById('birth_date')) {
                document.getElementById('birth_date').value = infos.birth_date || '';
            }
            if (document.getElementById('gender')) {
                document.getElementById('gender').value = infos.gender || '';
            }
        });

    // Attacher le submit
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = {
            firstname: document.getElementById('firstname').value,
            lastname: document.getElementById('lastname').value,
            bio: document.getElementById('bio').value,
            email: document.getElementById('email').value,
            phone: document.getElementById('phone').value,
            visibility: document.getElementById('visibility').value,
            show_email: document.getElementById('show-email').checked ? 1 : 0,
            relationship_status: document.getElementById('relationship_status').value,
            job_title: document.getElementById('job_title').value,
            company: document.getElementById('company').value,
            education: document.getElementById('education').value
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
                window.chargerPage('?page=profil');
            } else {
                alert(data.message || 'Erreur lors de la mise à jour');
            }
        });
    });

    // Annuler
    const btn_annuler = document.getElementById('cancel-edit');
    if (btn_annuler) {
        btn_annuler.addEventListener('click', function() {
            window.chargerPage('?page=profil');
        });
    }
}

// Si navigation SPA, appelle initProfilEditForm() à chaque affichage de la page profil_edit
// Sinon, place ce code dans un DOMContentLoaded
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('edit-profile-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = {
                firstname: document.getElementById('firstname').value,
                lastname: document.getElementById('lastname').value,
                bio: document.getElementById('bio').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
                visibility: document.getElementById('visibility').value,
                show_email: document.getElementById('show-email').checked ? 1 : 0,
                relationship_status: document.getElementById('relationship_status').value,
                job_title: document.getElementById('job_title').value,
                company: document.getElementById('company').value,
                education: document.getElementById('education').value
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
                    window.chargerPage('?page=profil');
                } else {
                    alert(data.message || 'Erreur lors de la mise à jour');
                }
            });
        });
    }

    const btn_annuler = document.getElementById('cancel-edit');
    if (btn_annuler) {
        btn_annuler.addEventListener('click', function() {
            window.chargerPage('?page=profil');
        });
    }
});

// Au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    // Afficher le bouton de modification quand l'identifiant ou le mail est modifié
    const identifiantInput = document.getElementById('identifiant');
    const emailInput = document.getElementById('email');
    const prenomInput = document.getElementById('prenom');
    const nomInput = document.getElementById('nom');
    const modifyButton = document.querySelector('button[type="submit"]');

    if (identifiantInput || emailInput) {
        // Si on est dans la page de modification du profil
        const inputs = [identifiantInput, emailInput, prenomInput, nomInput];

        inputs.forEach(input => {
            if (input) {
                input.addEventListener('change', function() {
                    if (modifyButton) {
                        modifyButton.classList.remove('d-none');
                    }
                });
            }
        });
    }

    // Gestion de l'affichage des favoris
    const divFavoris = document.getElementById('favoris-list');

    if (divFavoris) {
        const id_utilisateur = divFavoris.dataset.id;

        if (id_utilisateur) {
            fetch("?c=Favori&a=getFavoris&x&id=" + id_utilisateur)
                .then(response => response.json())
                .then(data => {
                    if (data.length === 0) {
                        divFavoris.innerHTML = '<p>Aucune recette favorite pour le moment.</p>';
                    } else {
                        let html = '<ul class="list-group">';
                        data.forEach(recette => {
                            html += `<li class="list-group-item">
                                <a href="?c=Recette&a=detail&id=${recette.id}">${recette.titre}</a>
                            </li>`;
                        });
                        html += '</ul>';
                        divFavoris.innerHTML = html;
                    }
                })
                .catch(error => {
                    console.error('Erreur lors du chargement des favoris:', error);
                    divFavoris.innerHTML = '<p class="text-danger">Erreur lors du chargement des favoris.</p>';
                });
        }
    }
});



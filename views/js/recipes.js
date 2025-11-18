// Au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    // Ne pas gérer les cartes si on a des zones cliquables spécifiques (liste.php)
    const hasClickableAreas = document.querySelectorAll('.recipe-clickable').length > 0;

    if (hasClickableAreas) {
        // Le script dans liste.php gère tout
        return;
    }

    // Faire en sorte que chaque "card" représentant une recette soit cliquable
    const recipes = document.querySelectorAll('.recipe');

    recipes.forEach(recipe => {
        recipe.addEventListener('mouseenter', function() {
            recipe.style.backgroundColor = '#f5f5f5';
        });

        recipe.addEventListener('mouseleave', function() {
            recipe.style.backgroundColor = '';
        });

        recipe.addEventListener('click', function(e) {
            // Ne pas rediriger si on clique sur un élément interactif
            const target = e.target;

            // Vérifier si on clique sur le cœur ou ses enfants
            if (target.closest('.recipe-fav')) {
                return; // Ne rien faire, le script dans liste.php gère ça
            }

            // Vérifier si on clique sur les boutons admin (liens, icônes)
            if (target.closest('a') ||
                target.closest('button') ||
                target.classList.contains('bi')) {
                return; // Ne rien faire pour les autres éléments cliquables
            }

            // Récupérer l'ID de la recette stockée dans l'attribut data
            const id = recipe.getAttribute('data-id');
            if (id) {
                window.location.href = `index.php?c=Recette&a=detail&id=${id}`;
            }
        });
    });
});


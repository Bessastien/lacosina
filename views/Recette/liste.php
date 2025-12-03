<h2>Liste des recettes</h2>

<div class="btn-group mb-4" role="group" aria-label="Filtrer par type de plat">
    <button type="button" class="btn btn-outline-primary filter-btn" data-type="">Tous</button>
    <button type="button" class="btn btn-outline-primary filter-btn" data-type="Entrée">Entrées</button>
    <button type="button" class="btn btn-outline-primary filter-btn" data-type="Plat">Plats</button>
    <button type="button" class="btn btn-outline-primary filter-btn" data-type="Dessert">Desserts</button>
</div>

<div class="row mt-4" id="recettes-container">
    <?php foreach ($recettes as $r): ?>
        <div class="col-md-4 mb-4">
            <div class="recipe card h-100" data-id="<?php echo $r['id']; ?>">
                <img src="<?php echo ($r['image'] ? $r['image'] : 'images/no_image.png'); ?>" class="card-img-top recipe-clickable" alt="<?php echo htmlspecialchars($r['titre']); ?>">
                <div class="card-body recipe-clickable">
                    <h5 class="card-title"><?php echo htmlspecialchars($r['titre']); ?></h5>
                    <p class="card-text"><?php echo htmlspecialchars(substr($r['description'], 0, 100)) . '...'; ?></p>
                    <p class="card-text"><small class="text-muted">Auteur: <a href="mailto:<?php echo htmlspecialchars($r['auteur']); ?>" onclick="event.stopPropagation();"><?php echo htmlspecialchars($r['auteur']); ?></a></small></p>
                </div>

                <div class="card-footer bg-transparent border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <?php if (isset($_SESSION['id'])): ?>
                                <span class="recipe-fav" data-id="<?php echo $r['id']; ?>" style="cursor: pointer; font-size: 1.5rem;" title="<?php echo in_array($r['id'], $favorisIds) ? 'Retirer des favoris' : 'Ajouter aux favoris'; ?>">
                                    <i class="bi <?php echo in_array($r['id'], $favorisIds) ? 'bi-heart-fill' : 'bi-heart'; ?>" style="color: red;"></i>
                                </span>
                            <?php endif; ?>
                            <?php if (isset($_SESSION['user_isAdmin']) && $_SESSION['user_isAdmin']): ?>
                                <a href="?c=Recette&a=modifier&id=<?php echo $r['id']; ?>" title="Modifier" onclick="event.stopPropagation();">
                                    <i class="bi bi-pencil-square" style="font-size: 1.3rem;"></i>
                                </a>
                                <a href="?c=Recette&a=supprimer&id=<?php echo $r['id']; ?>" title="Supprimer" onclick="event.stopPropagation(); return confirm('Êtes-vous sûr de vouloir supprimer cette recette ?');">
                                    <i class="bi bi-trash" style="font-size: 1.3rem; color: red;"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('recettes-container');
    const filterButtons = document.querySelectorAll('.filter-btn');
    const favorisIds = <?php echo json_encode($favorisIds); ?>;
    const isLoggedIn = <?php echo isset($_SESSION['id']) ? 'true' : 'false'; ?>;
    const isAdmin = <?php echo isset($_SESSION['user_isAdmin']) && $_SESSION['user_isAdmin'] ? 'true' : 'false'; ?>;

    // Charger toutes les recettes au démarrage
    loadRecettes('');

    // Gérer les clics sur les boutons de filtre
    filterButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            filterButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            loadRecettes(this.dataset.type);
        });
    });

    function loadRecettes(type) {
        const url = `?c=Recette&a=lister&ajax=1${type ? '&type_plat=' + encodeURIComponent(type) : ''}`;

        fetch(url)
            .then(response => response.json())
            .then(recettes => {
                container.innerHTML = '';
                recettes.forEach(recette => {
                    const isFavori = favorisIds.includes(recette.id);
                    const card = createRecetteCard(recette, isFavori);
                    container.appendChild(card);
                });
                attachEventListeners();
            })
            .catch(error => console.error('Erreur lors du chargement des recettes:', error));
    }

    function createRecetteCard(recette, isFavori) {
        const col = document.createElement('div');
        col.className = 'col-md-4 mb-4';

        const imageSrc = recette.image || 'images/no_image.png';
        const description = recette.description.substring(0, 100) + '...';

        let favoriHtml = '';
        if (isLoggedIn) {
            const heartClass = isFavori ? 'bi-heart-fill' : 'bi-heart';
            favoriHtml = `
                <span class="recipe-fav" data-id="${recette.id}" style="cursor: pointer; font-size: 1.5rem;" title="${isFavori ? 'Retirer des favoris' : 'Ajouter aux favoris'}">
                    <i class="bi ${heartClass}" style="color: red;"></i>
                </span>
            `;
        }

        let adminActionsHtml = '';
        if (isAdmin) {
            adminActionsHtml = `
                <a href="?c=Recette&a=modifier&id=${recette.id}" title="Modifier" onclick="event.stopPropagation();">
                    <i class="bi bi-pencil-square" style="font-size: 1.3rem;"></i>
                </a>
                <a href="?c=Recette&a=supprimer&id=${recette.id}" title="Supprimer" onclick="event.stopPropagation(); return confirm('Êtes-vous sûr de vouloir supprimer cette recette ?');">
                    <i class="bi bi-trash" style="font-size: 1.3rem; color: red;"></i>
                </a>
            `;
        }

        col.innerHTML = `
            <div class="recipe card h-100" data-id="${recette.id}">
                <img src="${imageSrc}" class="card-img-top recipe-clickable" alt="${recette.titre}">
                <div class="card-body recipe-clickable">
                    <h5 class="card-title">${recette.titre}</h5>
                    <span class="badge bg-secondary mb-2">${recette.type_plat || 'Plat'}</span>
                    <p class="card-text">${description}</p>
                    <p class="card-text"><small class="text-muted">Auteur: <a href="mailto:${recette.auteur}" onclick="event.stopPropagation();">${recette.auteur}</a></small></p>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            ${favoriHtml}
                            ${adminActionsHtml}
                        </div>
                    </div>
                </div>
            </div>
        `;

        return col;
    }

    function attachEventListeners() {
        // Gérer les favoris
        const heartIcons = document.querySelectorAll('.recipe-fav');
        heartIcons.forEach(heart => {
            heart.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const recetteId = this.dataset.id;
                window.location.href = '?c=Favori&a=ajouter&id=' + recetteId;
            });
        });

        // Gérer les clics sur les cartes
        const clickableAreas = document.querySelectorAll('.recipe-clickable');
        clickableAreas.forEach(area => {
            area.style.cursor = 'pointer';
            area.addEventListener('click', function(e) {
                if (e.target.tagName === 'A') return;
                const recipe = this.closest('.recipe');
                const id = recipe.getAttribute('data-id');
                if (id) {
                    window.location.href = `index.php?c=Recette&a=detail&id=${id}`;
                }
            });
            area.addEventListener('mouseenter', function() {
                this.style.backgroundColor = '#f5f5f5';
            });
            area.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
            });
        });
    }
});
</script>


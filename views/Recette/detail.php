<!-- Bouton retour en haut -->
<div class="mb-3">
    <a href="javascript:history.back()" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Retour
    </a>
</div>

<h1><?php echo htmlspecialchars($recette['titre']); ?></h1>
<img src="<?php echo ($recette['image'] ? $recette['image'] : 'images/no_image.png'); ?>" alt="<?php echo htmlspecialchars($recette['titre']); ?>" class="img-fluid mb-3" style="max-height: 400px; object-fit: cover;">
<p class="lead"><?php echo htmlspecialchars($recette['description']); ?></p>
<p><strong>Auteur:</strong> <a href="mailto:<?php echo htmlspecialchars($recette['auteur']); ?>"><?php echo htmlspecialchars($recette['auteur']); ?></a></p>
<p><small class="text-muted">Créée le: <?php echo $recette['date_creation']; ?></small></p>

<!-- Actions -->
<div class="mb-3">
    <?php if (isset($_SESSION['user_isAdmin']) && $_SESSION['user_isAdmin']): ?>
    <a href="index.php?c=Recette&a=modifier&id=<?php echo $recette['id']; ?>" class="btn btn-warning">
        <i class="bi bi-pencil-square"></i> Modifier
    </a>
    <a href="index.php?c=Recette&a=supprimer&id=<?php echo $recette['id']; ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette recette ?');">
        <i class="bi bi-trash"></i> Supprimer
    </a>
    <?php endif; ?>
    <?php if (isset($_SESSION['id'])): ?>
    <a href="index.php?c=Favori&a=ajouter&id=<?php echo $recette['id']; ?>" class="btn btn-primary">
        <i class="bi <?php echo $existe ? 'bi-heart-fill' : 'bi-heart'; ?>"></i>
        <?php echo $existe ? 'Retirer des favoris' : 'Ajouter aux favoris'; ?>
    </a>
    <?php endif; ?>
    <a href="index.php?c=Recette&a=lister" class="btn btn-secondary">
        <i class="bi bi-list-ul"></i> Retour à la liste
    </a>
</div>

<hr class="my-4">

<div id="commentaire-section">
    <h3>Commentaires</h3>
    <button id="bt-ajout-commentaire" class="btn btn-success mb-3" data-id="<?php echo $recette['id']; ?>">Ajouter un commentaire</button>

    <div id="div-commentaire">
        <?php if (empty($commentaires)): ?>
            <p>Aucun commentaire sur cette recette</p>
        <?php else: ?>
            <?php foreach ($commentaires as $comment): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($comment['pseudo']); ?></h5>
                        <p class="card-text"><?php echo nl2br(htmlspecialchars($comment['commentaire'])); ?></p>
                        <p class="card-text"><small class="text-muted"><?php echo $comment['create_time']; ?></small></p>
                        <?php if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']): ?>
                            <a href="index.php?c=Commentaire&a=supprimer&id=<?php echo $comment['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?');">
                                <i class="bi bi-trash"></i> Supprimer
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script>
// Gestion de l'ajout de commentaire
const btAjoutCommentaire = document.getElementById('bt-ajout-commentaire');
const divCommentaire = document.getElementById('div-commentaire');

if (btAjoutCommentaire) {
    btAjoutCommentaire.addEventListener('click', function() {
        // Crée un élément <form>
        let formComment = document.createElement('form');
        formComment.method = 'post';
        formComment.action = '?c=Commentaire&a=ajouter&id=' + btAjoutCommentaire.dataset.id;

        // Créer un textarea
        let textarea = document.createElement('textarea');
        textarea.name = 'commentaire';
        textarea.placeholder = 'Saisir le commentaire';
        textarea.rows = '4';
        textarea.classList.add('form-control');
        textarea.required = true;

        // Crée un bouton submit
        let submitButton = document.createElement('button');
        submitButton.type = 'submit';
        submitButton.textContent = 'Valider le commentaire';
        submitButton.classList.add('btn', 'btn-primary', 'mt-2');

        // Ajoute un div de class mb-3
        let divMessage = document.createElement('div');
        divMessage.classList.add('mb-3');
        divMessage.appendChild(textarea);
        divMessage.appendChild(submitButton);

        // Ajoute les éléments dans le formulaire
        formComment.appendChild(divMessage);
        divCommentaire.prepend(formComment);

        // Affiche le div commentaire
        btAjoutCommentaire.classList.add('d-none');
    });
}
</script>


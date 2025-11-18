<h2>Modifier la recette</h2>
<form method="POST" action="index.php?c=Recette&a=enregistrer" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $recette['id']; ?>">
    <div class="form-group">
        <label for="titre">Titre</label>
        <input type="text" class="form-control" id="titre" name="titre" value="<?php echo htmlspecialchars($recette['titre']); ?>" required>
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" rows="5" required><?php echo htmlspecialchars($recette['description']); ?></textarea>
    </div>
    <div class="form-group">
        <label for="auteur">Auteur</label>
        <input type="email" class="form-control" id="auteur" name="auteur" value="<?php echo htmlspecialchars($recette['auteur']); ?>" required>
    </div>
    <div class="form-group">
        <label for="image">Image de la recette</label>
        <?php if ($recette['image']): ?>
            <div class="mb-2">
                <img src="<?php echo $recette['image']; ?>" alt="<?php echo htmlspecialchars($recette['titre']); ?>" style="max-height: 200px;">
                <p><small>Image actuelle</small></p>
            </div>
        <?php endif; ?>
        <input type="file" class="form-control" id="image" name="image" accept="image/*">
        <small class="form-text text-muted">Laissez vide pour conserver l'image actuelle</small>
    </div>
    <button type="submit" class="btn btn-primary mt-3">Enregistrer les modifications</button>
    <a href="index.php?c=Recette&a=detail&id=<?php echo $recette['id']; ?>" class="btn btn-secondary mt-3">Annuler</a>
</form>


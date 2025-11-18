<h2>Ajouter une recette</h2>
<form method="POST" action="index.php?c=Recette&a=enregistrer" enctype="multipart/form-data">
    <div class="form-group">
        <label for="titre">Titre</label>
        <input type="text" class="form-control" id="titre" name="titre" required>
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
    </div>
    <div class="form-group">
        <label for="auteur">Auteur</label>
        <input type="email" class="form-control" id="auteur" name="auteur" required>
    </div>
    <div class="form-group">
        <label for="image">Image de la recette</label>
        <input type="file" class="form-control" id="image" name="image" accept="image/*">
        <small class="form-text text-muted">Format: JPG, PNG, GIF...</small>
    </div>
    <button type="submit" class="btn btn-primary mt-3">Ajouter</button>
</form>


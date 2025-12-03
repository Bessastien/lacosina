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
        <label for="auteur">Auteur (Email)</label>
        <input type="email" class="form-control" id="auteur" name="auteur" required>
    </div>
    <div class="form-group">
        <label for="type_plat">Type de plat</label>
        <select class="form-control" id="type_plat" name="type_plat" required>
            <option value="Entrée">Entrée</option>
            <option value="Plat" selected>Plat</option>
            <option value="Dessert">Dessert</option>
        </select>
    </div>
    <div class="form-group">
        <label for="image">Image de la recette</label>
        <input type="file" class="form-control" id="image" name="image" accept="image/*">
        <small class="form-text text-muted">Format: JPG, PNG, GIF...</small>
    </div>
    <?php if (!isset($_SESSION['user_isAdmin']) || !$_SESSION['user_isAdmin']): ?>
    <div class="alert alert-info mt-3">
        <i class="bi bi-info-circle"></i> Votre recette sera soumise à validation par un administrateur avant d'être publiée.
    </div>
    <?php endif; ?>
    <button type="submit" class="btn btn-primary mt-3">Ajouter</button>
</form>


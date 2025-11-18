<h2>Connexion</h2>
<?php if (isset($erreur)): ?>
    <div class="alert alert-danger"><?php echo $erreur; ?></div>
<?php endif; ?>
<form method="POST" action="index.php?c=User&a=connecter">
    <div class="form-group">
        <label for="identifiant">Identifiant</label>
        <input type="text" class="form-control" id="identifiant" name="identifiant" required>
    </div>
    <div class="form-group">
        <label for="password">Mot de passe</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <button type="submit" class="btn btn-primary mt-3">Se connecter</button>
</form>


<h2>Inscription</h2>
<form method="POST" action="index.php?c=User&a=enregistrer">
    <div class="form-group">
        <label for="identifiant">Identifiant</label>
        <input type="text" class="form-control" id="identifiant" name="identifiant" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="form-group">
        <label for="password">Mot de passe</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <button type="submit" class="btn btn-primary mt-3">S'inscrire</button>
</form>


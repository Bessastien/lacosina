<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2>Modifier mon profil</h2>
            <form method="POST">
                <div class="mb-3">
                    <label for="identifiant" class="form-label">Identifiant</label>
                    <input type="text" class="form-control" id="identifiant" name="identifiant" value="<?php echo htmlspecialchars($user['identifiant']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                <a href="index.php?c=User&a=profil" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
</div>


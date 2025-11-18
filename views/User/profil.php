<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    <img src="images/profil.png" alt="Profil" class="rounded-circle mb-3" style="width: 120px; height: 120px;">
                    <h2 class="card-title"><?php echo htmlspecialchars($_SESSION['user_identifiant']); ?></h2>
                    <p class="card-text"><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['user_email']); ?></p>
                    <p class="card-text">
                        <strong>Statut:</strong>
                        <?php echo ($_SESSION['user_isAdmin'] ? 'Administrateur' : 'Utilisateur'); ?>
                    </p>
                    <div class="mt-3">
                        <a href="index.php?c=User&a=modifier" class="btn btn-primary">Modifier le profil</a>
                        <a href="index.php?c=Recette&a=lister" class="btn btn-secondary">Retour</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


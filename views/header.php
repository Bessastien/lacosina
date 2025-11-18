<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Cosina - Recettes traditionnelles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="./views/js/recipes.js" defer></script>
    <script src="./views/js/users.js" defer></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">La Cosina</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?c=Recette&a=accueil">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?c=Recette&a=lister">Recettes</a>
                    </li>
                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_isAdmin']): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?c=Recette&a=ajouter">Ajouter une recette</a>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?c=Contact&a=ajouter">Contact</a>
                    </li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="images/profil.png" alt="Profil" class="rounded-circle" style="width: 30px; height: 30px;">
                            <?php echo $_SESSION['user_identifiant']; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href="index.php?c=User&a=profil">Mon profil</a></li>
                            <li><a class="dropdown-item" href="index.php?c=User&a=modifier">Modifier le profil</a></li>
                            <li><a class="dropdown-item" href="index.php?c=Favori&a=lister">Mes recettes favorites</a></li>
                            <?php if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']): ?>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="index.php?c=Commentaire&a=liste">Liste des commentaires</a></li>
                            <?php endif; ?>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="index.php?c=User&a=deconnexion">Déconnexion</a></li>
                        </ul>
                    </li>
                    <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?c=User&a=inscription">Inscription</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?c=User&a=connexion">Connexion</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container w-75 m-auto mt-5">
        <?php if (isset($_SESSION['message'])): ?>
            <?php foreach ($_SESSION['message'] as $type => $text): ?>
                <div class="alert alert-<?php echo $type; ?> alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($text); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endforeach; ?>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>


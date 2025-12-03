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
                <!-- Barre de recherche -->
                <div class="d-flex mx-auto" style="width: 400px;">
                    <input type="text" id="search-input" class="form-control" placeholder="Rechercher une recette...">
                    <div id="search-results" class="position-absolute bg-white border rounded shadow-sm" style="top: 100%; z-index: 1000; width: 400px; max-height: 400px; overflow-y: auto; display: none;"></div>
                </div>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?c=Recette&a=accueil">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?c=Recette&a=lister">Recettes</a>
                    </li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?c=Recette&a=ajouter">Proposer une recette</a>
                    </li>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_isAdmin']):
                        global $pdo;
                        $recetteModel = new Recette($pdo);
                        $commentaireModel = new Commentaire($pdo);
                        $pendingRecettes = $recetteModel->countPendingApproval();
                        $pendingComments = $commentaireModel->countPendingApproval();
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?c=Recette&a=pendingApproval">
                            Recettes à valider
                            <?php if ($pendingRecettes > 0): ?>
                                <span class="badge bg-danger"><?php echo $pendingRecettes; ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?c=Commentaire&a=pendingApproval">
                            Commentaires à valider
                            <?php if ($pendingComments > 0): ?>
                                <span class="badge bg-danger"><?php echo $pendingComments; ?></span>
                            <?php endif; ?>
                        </a>
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

    <script>
    // Recherche dynamique
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-input');
        const searchResults = document.getElementById('search-results');
        let searchTimeout;

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                const query = this.value.trim();

                if (query.length < 2) {
                    searchResults.style.display = 'none';
                    return;
                }

                searchTimeout = setTimeout(() => {
                    fetch(`?c=Recette&a=recherche&q=${encodeURIComponent(query)}`)
                        .then(response => response.json())
                        .then(recettes => {
                            if (recettes.length > 0) {
                                searchResults.innerHTML = recettes.map(recette => `
                                    <a href="?c=Recette&a=detail&id=${recette.id}" class="d-block p-2 text-decoration-none text-dark border-bottom hover-bg-light">
                                        <div class="d-flex align-items-center">
                                            <img src="${recette.image || 'images/no_image.png'}" alt="${recette.titre}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;" class="me-2">
                                            <div>
                                                <strong>${recette.titre}</strong>
                                                <br><small class="text-muted">${recette.type_plat || 'Plat'}</small>
                                            </div>
                                        </div>
                                    </a>
                                `).join('');
                                searchResults.style.display = 'block';
                            } else {
                                searchResults.innerHTML = '<div class="p-3 text-muted">Aucune recette trouvée</div>';
                                searchResults.style.display = 'block';
                            }
                        })
                        .catch(error => {
                            console.error('Erreur lors de la recherche:', error);
                            searchResults.style.display = 'none';
                        });
                }, 300);
            });

            // Fermer les résultats quand on clique ailleurs
            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                    searchResults.style.display = 'none';
                }
            });
        }
    });
    </script>


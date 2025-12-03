<?php

class RecetteController
{
    private $recette;

    public function __construct($recette)
    {
        $this->recette = $recette;
    }

    public function ajouter()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?c=User&a=connexion');
            exit;
        }
        include 'views/Recette/ajout.php';
    }

    public function enregistrer()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?c=User&a=connexion');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titre = htmlspecialchars($_POST['titre']);
            $description = htmlspecialchars($_POST['description']);
            $auteur = htmlspecialchars($_POST['auteur']);
            $type_plat = isset($_POST['type_plat']) ? htmlspecialchars($_POST['type_plat']) : 'Plat';
            $id = isset($_POST['id']) ? $_POST['id'] : null;

            $imagePath = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../images/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                $imagePath = $uploadDir . basename($_FILES['image']['name']);
                move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
                $imagePath = 'images/' . basename($_FILES['image']['name']);
            }

            $this->recette->setTitre($titre);
            $this->recette->setDescription($description);
            $this->recette->setAuteur($auteur);
            $this->recette->setTypePlat($type_plat);

            if ($imagePath) {
                $this->recette->setImage($imagePath);
            }

            if ($id) {
                $this->recette->update($id, $titre, $description, $auteur, $imagePath ? $imagePath : null, $type_plat);
            } else {
                // Les recettes des non-admins doivent être approuvées
                $isApproved = isset($_SESSION['user_isAdmin']) && $_SESSION['user_isAdmin'] ? 1 : 0;
                $this->recette->setIsApproved($isApproved);
                $this->recette->setDateCreation(date('Y-m-d H:i:s'));
                $this->recette->insert();

                // Log l'action avec Monolog
                $this->logAction('Nouvelle recette ajoutée : ' . $titre . ' par ' . $_SESSION['user_identifiant']);
            }

            include 'views/Recette/enregistrer.php';
        }
    }

    public function lister()
    {
        $type_plat = isset($_GET['type_plat']) ? $_GET['type_plat'] : null;
        $recettes = $this->recette->getAll($type_plat, true);

        // Si c'est une requête AJAX, retourner JSON
        if (isset($_GET['ajax']) && $_GET['ajax'] === '1') {
            header('Content-Type: application/json');
            echo json_encode($recettes);
            exit;
        }

        $favoriController = new FavoriController();
        $favorisIds = [];
        if (isset($_SESSION['id'])) {
            global $pdo;
            $favoriModel = new Favori($pdo);
            $favoris = $favoriModel->findBy(['user_id' => $_SESSION['id']]);
            foreach ($favoris as $favori) {
                $favorisIds[] = $favori['recette_id'];
            }
        }

        include 'views/Recette/liste.php';
    }

    public function detail()
    {
        if (isset($_GET['id'])) {
            $recette = $this->recette->getById($_GET['id']);

            $favoriController = new FavoriController();
            $existe = $favoriController->existe($_GET['id'], isset($_SESSION['id']) ? $_SESSION['id'] : null);

            $commentaireController = new CommentaireController();
            $commentaires = $commentaireController->lister($_GET['id']);

            include 'views/Recette/detail.php';
        }
    }

    public function accueil()
    {
        include 'views/Recette/accueil.php';
    }

    public function modifier()
    {
        if (!isset($_SESSION['user_isAdmin']) || !$_SESSION['user_isAdmin']) {
            header('Location: index.php?c=Recette&a=lister');
            exit;
        }

        if (isset($_GET['id'])) {
            $recette = $this->recette->getById($_GET['id']);
            include 'views/Recette/modifier.php';
        }
    }

    public function supprimer()
    {
        if (!isset($_SESSION['user_isAdmin']) || !$_SESSION['user_isAdmin']) {
            header('Location: index.php?c=Recette&a=lister');
            exit;
        }

        if (isset($_GET['id'])) {
            $this->recette->delete($_GET['id']);
            $_SESSION['message'] = ['success' => 'Recette supprimée avec succès'];
            header('Location: index.php?c=Recette&a=lister');
            exit;
        }
    }

    public function recherche()
    {
        if (isset($_GET['q'])) {
            $query = htmlspecialchars($_GET['q']);
            $recettes = $this->recette->search($query);

            header('Content-Type: application/json');
            echo json_encode($recettes);
            exit;
        }
    }

    public function pendingApproval()
    {
        if (!isset($_SESSION['user_isAdmin']) || !$_SESSION['user_isAdmin']) {
            header('Location: index.php?c=Recette&a=lister');
            exit;
        }

        $recettes = $this->recette->getPendingApproval();
        include 'views/Recette/pending_approval.php';
    }

    public function approveRecette()
    {
        if (!isset($_SESSION['user_isAdmin']) || !$_SESSION['user_isAdmin']) {
            header('Location: index.php?c=Recette&a=lister');
            exit;
        }

        if (isset($_GET['id'])) {
            $this->recette->approve($_GET['id']);
            $this->logAction('Recette #' . $_GET['id'] . ' approuvée par ' . $_SESSION['user_identifiant']);
            $_SESSION['message'] = ['success' => 'Recette approuvée avec succès'];
            header('Location: index.php?c=Recette&a=pendingApproval');
            exit;
        }
    }

    private function logAction($message)
    {
        // Charger Monolog si disponible
        if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
            require_once __DIR__ . '/../vendor/autoload.php';
            $log = new \Monolog\Logger('lacosina');
            $log->pushHandler(new \Monolog\Handler\StreamHandler(__DIR__ . '/../logs/app.log', \Monolog\Logger::INFO));
            $log->info($message);
        }
    }
}

?>

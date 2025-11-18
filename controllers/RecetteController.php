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
        if (!isset($_SESSION['user_isAdmin']) || !$_SESSION['user_isAdmin']) {
            header('Location: index.php?c=Recette&a=lister');
            exit;
        }
        include 'views/Recette/ajout.php';
    }

    public function enregistrer()
    {
        if (!isset($_SESSION['user_isAdmin']) || !$_SESSION['user_isAdmin']) {
            header('Location: index.php?c=Recette&a=lister');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titre = $_POST['titre'];
            $description = $_POST['description'];
            $auteur = $_POST['auteur'];
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

            if ($imagePath) {
                $this->recette->setImage($imagePath);
            }

            if ($id) {
                $this->recette->update($id, $titre, $description, $auteur, $imagePath ? $imagePath : null);
            } else {
                $this->recette->setDateCreation(date('Y-m-d H:i:s'));
                $this->recette->insert();
            }

            include 'views/Recette/enregistrer.php';
        }
    }

    public function lister()
    {
        $recettes = $this->recette->getAll();

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
}

?>

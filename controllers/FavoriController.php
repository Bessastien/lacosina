<?php

class FavoriController
{
    private $favoriModel;
    private $recetteModel;

    public function __construct()
    {
        global $pdo;
        $this->favoriModel = new Favori($pdo);
        $this->recetteModel = new Recette($pdo);
    }

    public function ajouter()
    {
        if (!isset($_SESSION['id'])) {
            $_SESSION['message'] = ['danger' => 'Vous devez être connecté pour ajouter des favoris'];
            header('Location: ?c=User&a=connexion');
            exit;
        }

        $id_recette = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $id_utilisateur = $_SESSION['id'];

        $ajout = $this->favoriModel->findBy(['user_id' => $id_utilisateur, 'recette_id' => $id_recette]);

        if (count($ajout) == 0) {
            $this->favoriModel->setUserId($id_utilisateur);
            $this->favoriModel->setRecetteId($id_recette);
            $this->favoriModel->setDateCreation(date('Y-m-d H:i:s'));
            $this->favoriModel->insert();
            $_SESSION['message'] = ['success' => 'Recette ajoutée aux favoris'];
        } else {
            $this->favoriModel->delete($id_utilisateur, $id_recette);
            $_SESSION['message'] = ['success' => 'Recette retirée des favoris'];
        }

        header('Location: ?c=Recette&a=detail&id=' . $id_recette);
        exit;
    }

    public function getFavoris()
    {
        if (!isset($_GET['id'])) {
            echo json_encode([]);
            return;
        }

        $id_utilisateur = intval($_GET['id']);
        $favoris = $this->favoriModel->findBy(['user_id' => $id_utilisateur]);
        $recettesFavori = [];

        foreach ($favoris as $favori) {
            $recette = $this->recetteModel->getById($favori['recette_id']);
            if ($recette) {
                $recettesFavori[] = $recette;
            }
        }

        header('Content-Type: application/json');
        echo json_encode($recettesFavori);
    }

    public function existe($recette_id, $user_id)
    {
        if ($user_id === null) {
            return false;
        }

        $favoris = $this->favoriModel->findBy(['user_id' => $user_id, 'recette_id' => $recette_id]);
        return count($favoris) > 0;
    }

    public function lister()
    {
        if (!isset($_SESSION['id'])) {
            header('Location: ?c=User&a=connexion');
            exit;
        }

        include 'views/User/favoris.php';
    }
}

?>


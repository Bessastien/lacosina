<?php

class CommentaireController
{
    private $commentaireModel;

    public function __construct()
    {
        global $pdo;
        $this->commentaireModel = new Commentaire($pdo);
    }

    public function lister($id)
    {
        $commentaires = $this->commentaireModel->findBy(['recette_id' => $id]);
        return $commentaires;
    }

    public function ajouter()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_recette = isset($_GET['id']) ? intval($_GET['id']) : 0;
            $commentaire = isset($_POST['commentaire']) ? trim($_POST['commentaire']) : '';

            if (empty($commentaire)) {
                $_SESSION['message'] = ['danger' => 'Le commentaire ne peut pas être vide'];
                header('Location: ?c=Recette&a=detail&id=' . $id_recette);
                exit;
            }

            $pseudo = isset($_SESSION['identifiant']) ? $_SESSION['identifiant'] : 'Anonyme';

            $this->commentaireModel->setRecetteId($id_recette);
            $this->commentaireModel->setPseudo($pseudo);
            $this->commentaireModel->setCommentaire($commentaire);
            $this->commentaireModel->setCreateTime(date('Y-m-d H:i:s'));
            $this->commentaireModel->insert();

            $_SESSION['message'] = ['success' => 'Commentaire ajouté avec succès'];
            header('Location: ?c=Recette&a=detail&id=' . $id_recette);
            exit;
        }
    }

    public function supprimer()
    {
        if (!isset($_SESSION['isAdmin']) || !$_SESSION['isAdmin']) {
            $_SESSION['message'] = ['danger' => 'Accès non autorisé'];
            header('Location: ?c=Recette&a=lister');
            exit;
        }

        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $this->commentaireModel->delete($id);
            $_SESSION['message'] = ['success' => 'Commentaire supprimé avec succès'];
        }

        header('Location: ?c=Commentaire&a=liste');
        exit;
    }

    public function liste()
    {
        if (!isset($_SESSION['isAdmin']) || !$_SESSION['isAdmin']) {
            $_SESSION['message'] = ['danger' => 'Accès non autorisé'];
            header('Location: ?c=Recette&a=lister');
            exit;
        }

        $commentaires = $this->commentaireModel->getAll();
        include 'views/Commentaire/liste.php';
    }
}

?>


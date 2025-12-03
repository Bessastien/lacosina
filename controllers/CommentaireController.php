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
            $this->commentaireModel->setCommentaire(htmlspecialchars($commentaire));
            $this->commentaireModel->setCreateTime(date('Y-m-d H:i:s'));
            $this->commentaireModel->setIsApproved(0); // Doit être approuvé par l'admin
            $this->commentaireModel->insert();

            $this->logAction('Nouveau commentaire par ' . $pseudo . ' sur la recette #' . $id_recette);

            $_SESSION['message'] = ['success' => 'Commentaire ajouté avec succès. Il sera visible après validation par un administrateur.'];
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

    public function pendingApproval()
    {
        if (!isset($_SESSION['isAdmin']) || !$_SESSION['isAdmin']) {
            $_SESSION['message'] = ['danger' => 'Accès non autorisé'];
            header('Location: ?c=Recette&a=lister');
            exit;
        }

        $commentaires = $this->commentaireModel->getPendingApproval();
        include 'views/Commentaire/pending_approval.php';
    }

    public function approveComment()
    {
        if (!isset($_SESSION['isAdmin']) || !$_SESSION['isAdmin']) {
            $_SESSION['message'] = ['danger' => 'Accès non autorisé'];
            header('Location: ?c=Recette&a=lister');
            exit;
        }

        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $this->commentaireModel->approve($id);
            $this->logAction('Commentaire #' . $id . ' approuvé par ' . $_SESSION['user_identifiant']);
            $_SESSION['message'] = ['success' => 'Commentaire approuvé avec succès'];
        }

        header('Location: ?c=Commentaire&a=pendingApproval');
        exit;
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


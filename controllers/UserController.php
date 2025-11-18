<?php

class UserController
{
    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function inscription()
    {
        include 'views/User/inscription.php';
    }

    public function enregistrer()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $identifiant = $_POST['identifiant'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $this->user->setIdentifiant($identifiant);
            $this->user->setEmail($email);
            $this->user->setPassword(password_hash($password, PASSWORD_DEFAULT));
            $this->user->insert();

            include 'views/User/enregistrement.php';
        }
    }

    public function connexion()
    {
        include 'views/User/connexion.php';
    }

    public function connecter()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $identifiant = $_POST['identifiant'];
            $password = $_POST['password'];

            $user = $this->user->getByIdentifiant($identifiant);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_identifiant'] = $user['identifiant'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_isAdmin'] = $user['isAdmin'];
                $_SESSION['id'] = $user['id'];
                $_SESSION['identifiant'] = $user['identifiant'];
                $_SESSION['isAdmin'] = $user['isAdmin'];
                header('Location: index.php?c=Recette&a=lister');
                exit;
            } else {
                $erreur = "Identifiant ou mot de passe incorrect";
                include 'views/User/connexion.php';
            }
        }
    }

    public function deconnexion()
    {
        session_destroy();
        header('Location: index.php?c=Recette&a=lister');
        exit;
    }

    public function profil()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?c=User&a=connexion');
            exit;
        }
        $user = $this->user->getById($_SESSION['user_id']);
        include 'views/User/profil.php';
    }

    public function modifier()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?c=User&a=connexion');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $identifiant = $_POST['identifiant'];
            $email = $_POST['email'];

            $this->user->update($_SESSION['user_id'], $identifiant, $email);

            $_SESSION['user_identifiant'] = $identifiant;
            $_SESSION['user_email'] = $email;

            header('Location: index.php?c=User&a=profil');
            exit;
        }

        $user = $this->user->getById($_SESSION['user_id']);
        include 'views/User/modifier.php';
    }
}

?>

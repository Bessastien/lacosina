<?php
session_start();

require_once 'models/connectDb.php';

require_once 'models/Recette.php';
require_once 'models/Contact.php';
require_once 'models/User.php';
require_once 'models/Favori.php';
require_once 'models/Commentaire.php';

require_once 'controllers/RecetteController.php';
require_once 'controllers/ContactController.php';
require_once 'controllers/UserController.php';
require_once 'controllers/FavoriController.php';
require_once 'controllers/CommentaireController.php';

if (!isset($_GET['x'])) {
    include 'views/header.php';
}

$controllerName = isset($_GET['c']) ? $_GET['c'] : 'Recette';
$actionName = isset($_GET['a']) ? $_GET['a'] : 'lister';

try {
    switch ($controllerName) {
        case 'Recette':
            $recette = new Recette($pdo);
            $controller = new RecetteController($recette);
            if (method_exists($controller, $actionName)) {
                $controller->$actionName();
            } else {
                echo "Action non trouvée";
            }
            break;

        case 'Contact':
            $contact = new Contact($pdo);
            $controller = new ContactController($contact);
            if (method_exists($controller, $actionName)) {
                $controller->$actionName();
            } else {
                echo "Action non trouvée";
            }
            break;

        case 'User':
            $user = new User($pdo);
            $controller = new UserController($user);
            if (method_exists($controller, $actionName)) {
                $controller->$actionName();
            } else {
                echo "Action non trouvée";
            }
            break;

        case 'Favori':
            $controller = new FavoriController();
            if (method_exists($controller, $actionName)) {
                $controller->$actionName();
            } else {
                echo "Action non trouvée";
            }
            break;

        case 'Commentaire':
            $controller = new CommentaireController();
            if (method_exists($controller, $actionName)) {
                $controller->$actionName();
            } else {
                echo "Action non trouvée";
            }
            break;

        default:
            $_SESSION['message'] = ['danger' => 'Page non trouvée'];
            header('Location: ?c=home');
            break;
    }
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}

if (!isset($_GET['x'])) {
    include 'views/footer.php';
}
?>


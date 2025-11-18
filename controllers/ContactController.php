<?php

class ContactController
{
    private $contact;

    public function __construct($contact)
    {
        $this->contact = $contact;
    }

    public function ajouter()
    {
        include 'views/Contact/ajout.php';
    }

    public function enregistrer()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->contact->setNom($_POST['nom']);
            $this->contact->setPrenom($_POST['prenom']);
            $this->contact->setEmail($_POST['email']);
            $this->contact->setMessage($_POST['message']);
            $this->contact->setDateCreation(date('Y-m-d H:i:s'));
            $this->contact->insert();

            $to = "contact@lacosina.fr";
            $subject = "Nouveau message de contact";
            $body = "Nom: " . $_POST['nom'] . "\n";
            $body .= "Prénom: " . $_POST['prenom'] . "\n";
            $body .= "Email: " . $_POST['email'] . "\n";
            $body .= "Message: " . $_POST['message'] . "\n";

            mail($to, $subject, $body);

            include 'views/Contact/enregistrer.php';
        }
    }
}

?>


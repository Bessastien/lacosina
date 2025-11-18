<?php

class Recette
{
    private $id;
    private $titre;
    private $description;
    private $auteur;
    private $image;
    private $date_creation;
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitre()
    {
        return $this->titre;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getAuteur()
    {
        return $this->auteur;
    }

    public function getDateCreation()
    {
        return $this->date_creation;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;
    }

    public function setDateCreation($date_creation)
    {
        $this->date_creation = $date_creation;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function insert()
    {
        $sql = "INSERT INTO recettes (titre, description, auteur, image, date_creation) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$this->titre, $this->description, $this->auteur, $this->image, $this->date_creation]);
    }

    public function getAll()
    {
        $sql = "SELECT * FROM recettes";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM recettes WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM recettes WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
    }

    public function update($id, $titre, $description, $auteur, $image)
    {
        if ($image) {
            $sql = "UPDATE recettes SET titre = ?, description = ?, auteur = ?, image = ? WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$titre, $description, $auteur, $image, $id]);
        } else {
            $sql = "UPDATE recettes SET titre = ?, description = ?, auteur = ? WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$titre, $description, $auteur, $id]);
        }
    }
}

?>


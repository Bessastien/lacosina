<?php

class Recette
{
    private $id;
    private $titre;
    private $description;
    private $auteur;
    private $image;
    private $date_creation;
    private $type_plat;
    private $isApproved;
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

    public function getTypePlat()
    {
        return $this->type_plat;
    }

    public function setTypePlat($type_plat)
    {
        $this->type_plat = $type_plat;
    }

    public function getIsApproved()
    {
        return $this->isApproved;
    }

    public function setIsApproved($isApproved)
    {
        $this->isApproved = $isApproved;
    }

    public function insert()
    {
        $sql = "INSERT INTO recettes (titre, description, auteur, image, date_creation, type_plat, isApproved) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$this->titre, $this->description, $this->auteur, $this->image, $this->date_creation, $this->type_plat, $this->isApproved]);
    }

    public function getAll($type_plat = null, $onlyApproved = true)
    {
        $sql = "SELECT * FROM recettes WHERE 1=1";
        $params = [];

        if ($onlyApproved) {
            $sql .= " AND isApproved = 1";
        }

        if ($type_plat) {
            $sql .= " AND type_plat = ?";
            $params[] = $type_plat;
        }

        $sql .= " ORDER BY date_creation DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPendingApproval()
    {
        $sql = "SELECT * FROM recettes WHERE isApproved = 0 ORDER BY date_creation DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countPendingApproval()
    {
        $sql = "SELECT COUNT(*) as count FROM recettes WHERE isApproved = 0";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
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

    public function update($id, $titre, $description, $auteur, $image, $type_plat = null)
    {
        if ($image) {
            if ($type_plat) {
                $sql = "UPDATE recettes SET titre = ?, description = ?, auteur = ?, image = ?, type_plat = ? WHERE id = ?";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$titre, $description, $auteur, $image, $type_plat, $id]);
            } else {
                $sql = "UPDATE recettes SET titre = ?, description = ?, auteur = ?, image = ? WHERE id = ?";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$titre, $description, $auteur, $image, $id]);
            }
        } else {
            if ($type_plat) {
                $sql = "UPDATE recettes SET titre = ?, description = ?, auteur = ?, type_plat = ? WHERE id = ?";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$titre, $description, $auteur, $type_plat, $id]);
            } else {
                $sql = "UPDATE recettes SET titre = ?, description = ?, auteur = ? WHERE id = ?";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$titre, $description, $auteur, $id]);
            }
        }
    }

    public function approve($id)
    {
        $sql = "UPDATE recettes SET isApproved = 1 WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
    }

    public function search($query)
    {
        $sql = "SELECT * FROM recettes WHERE isApproved = 1 AND (titre LIKE ? OR description LIKE ?) ORDER BY date_creation DESC";
        $searchTerm = "%$query%";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$searchTerm, $searchTerm]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>


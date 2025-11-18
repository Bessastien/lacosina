<?php

class Favori
{
    private $id;
    private $user_id;
    private $recette_id;
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

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getRecetteId()
    {
        return $this->recette_id;
    }

    public function getDateCreation()
    {
        return $this->date_creation;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function setRecetteId($recette_id)
    {
        $this->recette_id = $recette_id;
    }

    public function setDateCreation($date_creation)
    {
        $this->date_creation = $date_creation;
    }

    public function insert()
    {
        $sql = "INSERT INTO favoris (user_id, recette_id, date_creation) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$this->user_id, $this->recette_id, $this->date_creation]);
    }

    public function getAll()
    {
        $sql = "SELECT * FROM favoris";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findBy($conditions)
    {
        $where = [];
        $params = [];
        foreach ($conditions as $key => $value) {
            $where[] = "$key = ?";
            $params[] = $value;
        }
        $sql = "SELECT * FROM favoris WHERE " . implode(' AND ', $where);
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($user_id, $recette_id)
    {
        $sql = "DELETE FROM favoris WHERE user_id = ? AND recette_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id, $recette_id]);
    }
}

?>


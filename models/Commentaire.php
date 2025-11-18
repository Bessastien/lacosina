<?php

class Commentaire
{
    private $id;
    private $recette_id;
    private $pseudo;
    private $commentaire;
    private $create_time;
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getRecetteId()
    {
        return $this->recette_id;
    }

    public function getPseudo()
    {
        return $this->pseudo;
    }

    public function getCommentaire()
    {
        return $this->commentaire;
    }

    public function getCreateTime()
    {
        return $this->create_time;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setRecetteId($recette_id)
    {
        $this->recette_id = $recette_id;
    }

    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;
    }

    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;
    }

    public function setCreateTime($create_time)
    {
        $this->create_time = $create_time;
    }

    public function insert()
    {
        $sql = "INSERT INTO comments (recette_id, pseudo, commentaire, create_time) VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$this->recette_id, $this->pseudo, $this->commentaire, $this->create_time]);
    }

    public function getAll()
    {
        $sql = "SELECT * FROM comments ORDER BY create_time DESC";
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
        $sql = "SELECT * FROM comments WHERE " . implode(' AND ', $where) . " ORDER BY create_time DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM comments WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
    }
}

?>


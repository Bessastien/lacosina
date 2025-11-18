<?php

class User
{
    private $id;
    private $identifiant;
    private $email;
    private $password;
    private $isAdmin;
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getIdentifiant()
    {
        return $this->identifiant;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getIsAdmin()
    {
        return $this->isAdmin;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setIdentifiant($identifiant)
    {
        $this->identifiant = $identifiant;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }


    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;
    }

    public function insert()
    {
        $sql = "INSERT INTO users (identifiant, email, password) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$this->identifiant, $this->email, $this->password]);
    }

    public function getAll()
    {
        $sql = "SELECT * FROM users";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByIdentifiant($identifiant)
    {
        $sql = "SELECT * FROM users WHERE identifiant = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$identifiant]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
    }

    public function update($id, $identifiant, $email)
    {
        $sql = "UPDATE users SET identifiant = ?, email = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$identifiant, $email, $id]);
    }
}

?>


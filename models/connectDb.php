<?php
/**
 * Configuration de la connexion à la base de données
 * Compatible avec MAMP, XAMPP, WAMP et serveurs de production
 */

// Configuration de la base de données
$host = "localhost";      // ou "127.0.0.1" si localhost ne fonctionne pas
$dbname = "lacosina";
$user = "root";
$password = "root";       // MAMP: "root" | XAMPP/WAMP: "" (vide)

// Options PDO pour améliorer la sécurité et les performances
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
];

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $user,
        $password,
        $options
    );
} catch (PDOException $e) {
    // En production, ne pas afficher les détails de l'erreur
    if (getenv('APP_ENV') === 'production') {
        die('Erreur de connexion à la base de données.');
    } else {
        die('Erreur de connexion : ' . $e->getMessage());
    }
}
?>


<?php
try
{
    $host = "localhost";
    $dbname = "lacosina";
    $user = "root";
    $password = "";
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
}
catch (Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}
?>


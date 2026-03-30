<?php
/*
    ============================================================
    FICHIER : database.php
    RÔLE DU FICHIER :
    Ce fichier sert à créer la connexion entre PHP
    et la base de données MySQL avec PDO.

    CE QUE CE FICHIER VA FAIRE :
    - Définir les informations de connexion
    - Tenter une connexion à la base
    - Stocker cette connexion dans la variable $pdo

    RAPPEL SUR PDO :
    PDO signifie PHP Data Objects.
    C'est l'outil moderne de PHP pour communiquer
    avec une base de données.

    ANALOGIE :
    Si notre application était un restaurant, ce fichier
    serait la route qui relie la salle du restaurant
    à la cuisine. Sans cette liaison, impossible
    de transmettre les demandes.
    ============================================================
*/

$host = 'localhost';
$dbname = 'blog_mvc';
$username = 'root';
$password = '';

try {
    /*
        On crée la connexion à la base de données.
        La variable $pdo contiendra notre connexion.
    */
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    /*
        On active le mode exception pour obtenir des
        messages d'erreur plus clairs pendant le développement.
    */
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    /*
        Si la connexion échoue, on affiche un message
        puis on arrête le script.
    */
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}
?>
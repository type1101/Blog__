<?php
/*
    ============================================================
    FICHIER : header.php
    RÔLE DU FICHIER :
    Ce fichier contient le début de la structure HTML
    et la navigation principale du site.

    CE QUE CE FICHIER VA FAIRE :
    - Définir le début de la page HTML
    - Charger les métadonnées
    - Lier le fichier CSS externe
    - Afficher l'en-tête du site
    - Afficher une navigation simple

    ANALOGIE :
    Si le site était une maison, ce fichier serait
    la structure de base et l'entrée principale,
    avec le panneau qui indique où aller.
    ============================================================
*/
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Blog MVC</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header>
    <h1>Mon Blog MVC</h1>
    <p>Projet pédagogique en PHP avec architecture MVC</p>

    <nav>
        <a href="index.php">Accueil</a>

        <?php
        /*
            Si un utilisateur est connecté, on affiche
            les liens vers la création de post et la déconnexion.
        */
        if (isset($_SESSION['user'])) {
            ?>
            <a href="index.php?action=showCreate">Créer un post</a>
            <a href="index.php?action=logout">Se déconnecter</a>
            <?php
        } else {
            /*
                Sinon, on affiche le lien de connexion.
            */
            ?>
            <a href="index.php?action=showLogin">Connexion</a>
            <a href="index.php?action=showRegister">inscription</a>
            <?php
        }
        ?>
    </nav>

    <?php
    /*
        Si un utilisateur est connecté, on affiche son nom.
    */
    if (isset($_SESSION['user'])) {
        ?>
        <p>Connecté en tant que : <strong><?php echo htmlspecialchars($_SESSION['user']['username']); ?></strong></p>
        <?php
    }
    ?>
</header>
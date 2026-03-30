<?php
/*
    ============================================================
    FICHIER : login.php
    RÔLE DU FICHIER :
    Cette vue affiche le formulaire de connexion.

    CE QUE CE FICHIER VA FAIRE :
    - Afficher le header
    - Afficher un formulaire de connexion
    - Afficher un message d'erreur si nécessaire

    IMPORTANT :
    Cette vue ne vérifie pas le mot de passe elle-même.
    Elle envoie simplement les informations au contrôleur.

    ANALOGIE :
    Si l'application était un restaurant privé, cette vue
    serait le poste d'accueil où l'on vérifie l'identité
    avant de laisser entrer une personne dans l'espace réservé.
    ============================================================
*/

require_once 'view/partial/header.php';
?>

<main>
    <h2>Connexion</h2>

    <?php
    /*
        Si un message d'erreur existe, on l'affiche.
    */
    if ($errorMessage != '') {
        ?>
        <div class="error-message">
            <p><?php echo htmlspecialchars($errorMessage); ?></p>
        </div>
        <?php
    }
    ?>

    <form action="index.php" method="POST">
        <div>
            <label for="email">Email :</label><br>
            <input type="email" id="email" name="email" required>
        </div>

        <br>

        <div>
            <label for="password">Mot de passe :</label><br>
            <input type="password" id="password" name="password" required>
        </div>

        <br>

        <div>
            <button type="submit" name="action" value="login">Se connecter</button>
        </div>
    </form>
</main>

<?php
require_once 'view/partial/footer.php';
?>

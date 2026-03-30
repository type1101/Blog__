<?php
/*
    ============================================================
    FICHIER : create.php
    RÔLE DU FICHIER :
    Cette vue affiche le formulaire de création d'un post.

    CE QUE CE FICHIER VA FAIRE :
    - Afficher le header
    - Afficher un formulaire HTML
    - Envoyer les données au contrôleur

    IMPORTANT :
    Cette vue affiche le formulaire, mais elle ne traite
    pas le formulaire. Le traitement est fait dans le contrôleur.

    ANALOGIE :
    Si l'application était un restaurant, cette vue serait
    le bon de commande rempli par le client.
    ============================================================
*/

require_once 'view/partial/header.php';
?>

<main>
    <h2>Créer un nouveau post</h2>

    <form action="index.php" method="POST">
        <div>
            <label for="title">Titre :</label><br>
            <input type="text" id="title" name="title" required>
        </div>

        <br>

        <div>
            <label for="content">Contenu :</label><br>
            <textarea id="content" name="content" rows="6" required></textarea>
        </div>

        <br>

        <div>
            <label for="image_path">Chemin de l'image (prévu pour plus tard) :</label><br>
            <input type="text" id="image_path" name="image_path" placeholder="uploads/image.jpg">
        </div>

        <br>

        <div>
            <button type="submit" name="action" value="createPost">Publier</button>
        </div>
    </form>
</main>

<?php
require_once 'view/partial/footer.php';
?>
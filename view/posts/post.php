<?php
/*
    ============================================================
    FICHIER : post.php
    RÔLE DU FICHIER :
    Cette vue affiche la liste des publications du blog.

    CE QUE CE FICHIER VA FAIRE :
    - Afficher le header
    - Parcourir les posts envoyés par le contrôleur
    - Afficher chaque publication
    - Afficher un message si aucun post n'existe

    IMPORTANT :
    Cette vue ne récupère pas les données elle-même.
    Elle se contente d'afficher ce qu'elle reçoit.

    ANALOGIE :
    Si l'application était un restaurant, cette vue
    serait l'assiette servie au client.
    ============================================================
*/

require_once 'view/partial/header.php';
?>

<main>
    <h2>Liste des publications</h2>

    <?php
    /*
        On vérifie s'il existe au moins un post.
    */
    if (count($posts) > 0) {

        /*
            On parcourt tous les posts.
        */
        foreach ($posts as $post) {
            ?>
            <article>
                <h3><?php echo htmlspecialchars($post['title']); ?></h3>

                <p class="meta">
                    Publié par <?php echo htmlspecialchars($post['username']); ?>
                    le <?php echo htmlspecialchars($post['created_at']); ?>
                </p>

                <p>
                    <?php echo nl2br(htmlspecialchars($post['content'])); ?>
                </p>

                <?php
                /*
                    Si une image existe, on l'affiche.
                    Cela prépare déjà l'évolution future vers l'ajout d'images.
                */
                $video = strtolower(pathinfo($post['image_path'], PATHINFO_EXTENSION));

                if ($post['image_path'] != null && $post['image_path'] != '') {
                    if ($video == 'mp4' || $video == 'mov') {
                        ?>
                        <video class="video" controls = "controls" src="<?php echo htmlspecialchars($post['image_path']); ?>"></video>
                        <?php
                    } else {
                        ?>
                        <img src="<?php echo htmlspecialchars($post['image_path']); ?>" alt="Image du post">
                        <?php
                    }
                }


                ?>
            </article>
            <?php
        }

    } else {
        /*
            Si aucun post n'existe, on affiche un message.
        */
        ?>
        <div class="empty-message">
            <p>Aucune publication n'est disponible pour le moment.</p>
        </div>
        <?php
    }
    ?>
</main>

<?php
require_once 'view/partial/footer.php';
?>
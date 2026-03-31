<?php
/*
    ============================================================
    FICHIER : postModels.php
    RÔLE DU FICHIER :
    Ce fichier contient les fonctions qui dialoguent
    avec la base de données.

    CE QUE CE FICHIER VA FAIRE :
    - Récupérer les posts
    - Créer un nouveau post
    - Récupérer un utilisateur par son email pour la connexion

    IMPORTANT :
    Ce fichier ne doit jamais afficher de HTML.
    Il travaille uniquement avec les données.

    ANALOGIE :
    Si l'application était un restaurant, ce fichier
    serait la cuisine. La cuisine prépare les plats,
    mais elle ne va pas les apporter elle-même au client.
    ============================================================
*/

/*
    ============================================================
    FONCTION : getAllPosts
    RÔLE :
    Récupérer tous les posts avec le nom de l'auteur
    ============================================================
*/


function getAllPosts($pdo)
{
    /*
        On prépare une requête SQL qui récupère les posts
        ainsi que le nom de l'utilisateur qui a publié.
    */
    $sql = "
        SELECT
            posts.id,
            posts.title,
            posts.content,
            posts.image_path,
            posts.created_at,
            posts.user_id,
            users.username
        FROM posts
        INNER JOIN users ON posts.user_id = users.id
        ORDER BY posts.created_at DESC
    ";

    /*
        On exécute la requête.
    */
    $statement = $pdo->query($sql);

    /*
        On récupère tous les résultats sous forme de tableau associatif.
    */
    $posts = $statement->fetchAll(PDO::FETCH_ASSOC);

    /*
        On renvoie les résultats au contrôleur.
    */
    return $posts;
}

/*
    ============================================================
    FONCTION : createPost
    RÔLE :
    Ajouter un nouveau post dans la base de données
    ============================================================
*/
function createPost($pdo, $title, $content, $media , $user_id)
{
    /*
        On prépare une requête SQL avec des paramètres.
        Cela permet d'éviter les injections SQL.
    */
    $sql = "
        INSERT INTO posts (title, content, image_path, user_id)
        VALUES (?, ?, ?, ?)
    ";

    /*
        On prépare la requête.
    */
    $statement = $pdo->prepare($sql);

    /*
        On exécute la requête avec les valeurs reçues.
    */
    $statement->execute([$title, $content, $media, $user_id]);
}

function deletePost($pdo, $post_id, $user_id)
{
    /*
        On prépare une requête SQL pour supprimer le post.
        On vérifie aussi que le post appartient bien à l'utilisateur (sécurité).
    */
    $sql = "
        DELETE FROM posts
        WHERE id = ? AND user_id = ?
    ";

    /*
        On prépare la requête.
    */
    $statement = $pdo->prepare($sql);

    /*
        On exécute la requête avec l'ID du post et l'ID de l'utilisateur.
    */
    $statement->execute([$post_id, $user_id]);

    /*
        On retourne le nombre de lignes supprimées.
        Si c'est 0, c'est que l'utilisateur n'est pas propriétaire du post.
    */
    return $statement->rowCount();
}
?>


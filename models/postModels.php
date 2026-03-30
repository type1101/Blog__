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

function createUser($pdo, $username, $email, $password)
{
    $sql = "
        INSERT INTO users (username, email, password)
        VALUES (?, ?, ?)
    ";

    $statement = $pdo->prepare($sql);

    $statement->execute([$username, $email, $password]);
}



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
function createPost($pdo, $title, $content, $image_path, $user_id)
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
    $statement->execute([$title, $content, $image_path, $user_id]);
}

/*
    ============================================================
    FONCTION : getUserByEmail
    RÔLE :
    Récupérer un utilisateur à partir de son email
    ============================================================
*/
function getUserByEmail($pdo, $email)
{
    /*
        On prépare une requête pour chercher un utilisateur
        dont l'email correspond à celui saisi dans le formulaire.
    */
    $sql = "SELECT * FROM users WHERE email = ?";

    /*
        On prépare la requête.
    */
    $statement = $pdo->prepare($sql);

    /*
        On exécute la requête avec l'email reçu.
    */
    $statement->execute([$email]);

    /*
        On récupère une seule ligne, car un email doit être unique.
    */
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    /*
        On renvoie l'utilisateur trouvé, ou false si aucun utilisateur
        ne correspond.
    */
    return $user;
}
?>
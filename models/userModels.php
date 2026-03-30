<?php

function createUser($pdo, $username, $email, $password)
{
    $sql = "
        INSERT INTO users (username, email, password)
        VALUES (?, ?, ?)
    ";

    $statement = $pdo->prepare($sql);

    $statement->execute([$username, $email, $password]);
}



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


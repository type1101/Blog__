<?php
/*
    ============================================================
    FICHIER : userControllers.php
    RÔLE DU FICHIER :
    Ce fichier joue le rôle de contrôleur principal.

    CE QUE CE FICHIER VA FAIRE :
    - Charger la connexion à la base
    - Charger les fonctions du modèle
    - Gérer les actions de l'utilisateur
    - Afficher la bonne vue au bon moment

    IMPORTANT :
    Le contrôleur organise le travail.
    Il ne doit pas contenir tout le HTML, et il ne doit pas
    contenir directement toute la logique SQL.

    ANALOGIE :
    Si l'application était un restaurant, ce fichier serait
    le serveur. Il reçoit la demande du client, va en cuisine,
    récupère le résultat, puis l'apporte à la bonne table.
    ============================================================
*/

/*
    On charge la connexion à la base de données.
*/
/*require_once 'config/database.php';*/

/*
    On charge le modèle.
*/
require_once 'models/userModels.php';
/*require_once 'models/postModels.php';*/
/*
    On prépare une variable d'erreur vide.
    Elle servira si la connexion échoue.
*/
/*$errorMessage = '';*/

/*
    ============================================================
    1. GESTION DES ACTIONS EN GET
    ============================================================
*/


    /*
        Si l'utilisateur demande la déconnexion,
        on détruit les informations de session.
    */
if (isset($_GET['action']) && $_GET['action'] == 'logout') {

        /*
            On vide le tableau de session.
        */
    $_SESSION = [];

        /*
            On détruit la session.
        */
    session_destroy();

        /*
            On redirige vers l'accueil.
        */
    header('Location: index.php');
    exit();
}

/*
    ============================================================
    2. GESTION DES FORMULAIRES EN POST
    ============================================================
*/
if (isset($_POST['action'])) {

    /*
        --------------------------------------------------------
        FORMULAIRE DE CONNEXION compte utilisateur : netypareo@gmail.com / OPARE78@ 
        --------------------------------------------------------
    */
    if ($_POST['action'] == 'login') {

        /*
            On récupère les valeurs envoyées par le formulaire.
            trim() enlève les espaces inutiles au début et à la fin.
        */
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        /*
            On cherche l'utilisateur dans la base grâce à son email.
        */
        $user = getUserByEmail($pdo, $email);

        /*
            On vérifie si un utilisateur a été trouvé.
        */
        if ($user) {

            /*
                On vérifie ensuite si le mot de passe saisi
                correspond au hash stocké en base.
            */
            if (password_verify($password, $user['password'])) {

                /*
                    Si le mot de passe est correct, on enregistre
                    les informations utiles dans la session.
                */
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'role' => $user['role']
                ];

                /*
                    On redirige vers l'accueil.
                */
                header('Location: index.php');
                exit();

            } else {
                /*
                    Le mot de passe est faux.
                */
                header('Location: index.php?action=showLogin&error=pass_wrong');
                exit();
            }

        } else {
            /*
                Aucun utilisateur ne correspond à cet email.
            */
            header('Location: index.php?action=showLogin&error=email_not_found');
            exit();
        }
    }

    /*
        --------------------------------------------------------
        FORMULAIRE D'INSCRIPTION
        --------------------------------------------------------
    */
    if ($_POST['action'] == 'register') {

        /*
            On récupère les valeurs envoyées par le formulaire.
            trim() enlève les espaces inutiles au début et à la fin.
        */
        $username  = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $confirm_password = trim($_POST['confirm_password']);

        $user = getUserByEmail($pdo, $email);

        /*
            On vérifie si un utilisateur a été trouvé.
        */
        if ($user == false) {

            if ($username != '' && $email != '' && $password != '' && $confirm_password != '') {

                if ($password == $confirm_password) {

                    $password = password_hash($password, PASSWORD_DEFAULT);

                    createUser($pdo, $username, $email, $password);

                    $user = getUserByEmail($pdo, $email);

                    $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'role' => $user['role']
                    ];

                    
                } else if (strlen($password) < 6) {
                    header('Location: index.php?action=showRegister&error=pass_short');
                    exit();
                } else {
                    header('Location: index.php?action=showRegister&error=pass_no_match');
                    exit();
                }

            } else {
                header('Location: index.php?action=showRegister&error=empty');
                exit();
            }

        } else {
            /*
                Aucun utilisateur ne correspond à cet email.
            */
            header('Location: index.php?action=showRegister&error=email_exist');
            exit();
        }
    }

}

/*
    ============================================================
    3. AFFICHAGE PAR DÉFAUT : LISTE DES POSTS
    ============================================================
*/

/*
    On récupère tous les posts.
*/
/*
$posts = getAllPosts($pdo);

/*
    On affiche la vue principale.

require_once 'view/posts/post.php';
*/

?>

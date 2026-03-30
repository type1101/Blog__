<?php
/*
    ============================================================
    FICHIER : postControllers.php
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
require_once 'config/database.php';

/*
    On charge le modèle.
*/
require_once 'models/postModels.php';

/*
    On prépare une variable d'erreur vide.
    Elle servira si la connexion échoue.
*/
$errorMessage = '';

/*
    ============================================================
    1. GESTION DES ACTIONS EN GET
    ============================================================
*/
if (isset($_GET['action'])) {

    /*
        Si l'utilisateur demande le formulaire de connexion,
        on affiche la vue login.php.
    */
    if ($_GET['action'] == 'showLogin') {
        require_once 'view/users/login.php';
        exit();
    }

    if($_GET['action'] == 'showRegister'){
        require_once 'view/users/register.php';
        exit();
    }

    /*
        Si l'utilisateur demande le formulaire de création,
        on vérifie d'abord qu'il est connecté.
    */
    else if ($_GET['action'] == 'showCreate') {

        if (isset($_SESSION['user'])) {
            require_once 'view/posts/create.php';
            exit();
        } else {
            header('Location: index.php?action=showLogin');
            exit();
        }
    }

    /*
        Si l'utilisateur demande la déconnexion,
        on détruit les informations de session.
    */
    else if ($_GET['action'] == 'logout') {

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
                $errorMessage = 'Mot de passe incorrect.';
                require_once 'view/users/login.php';
                exit();
            }

        } else {
            /*
                Aucun utilisateur ne correspond à cet email.
            */
            $errorMessage = 'Aucun utilisateur trouvé avec cet email.';
            require_once 'view/users/login.php';
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

                    
                } else {
                    $errorMessage = 'Les mots de passe ne correspondent pas.';
                }

            } else {
                $errorMessage = 'Veuillez remplir tous les champs.';
            }

        } else {
            /*
                Aucun utilisateur ne correspond à cet email.
            */
            $errorMessage = 'email deja existant.';
            require_once 'view/users/register.php';
            exit();
        }
    }


    /*
        --------------------------------------------------------
        FORMULAIRE DE CRÉATION DE POST
        --------------------------------------------------------
    */
    else if ($_POST['action'] == 'createPost') {

        /*
            On vérifie que l'utilisateur est connecté.
        */
        if (isset($_SESSION['user'])) {

            /*
                On récupère les données du formulaire.
            */
            $title = trim($_POST['title']);
            $content = trim($_POST['content']);
            $image_path = trim($_POST['image_path']);

            /*
                On récupère l'identifiant de l'utilisateur connecté.
            */
            $user_id = $_SESSION['user']['id'];

            /*
                Si le champ image est vide, on met NULL
                pour rester propre en base.
            */
            if ($image_path == '') {
                $image_path = null;
            }

            /*
                On vérifie que les champs obligatoires ne sont pas vides.
            */
            if ($title != '' && $content != '') {

                /*
                    On appelle la fonction du modèle pour insérer le post.
                */
                createPost($pdo, $title, $content, $image_path, $user_id);

                /*
                    On redirige vers l'accueil après l'insertion.
                */
                header('Location: index.php');
                exit();

            } else {
                /*
                    Si un champ obligatoire est vide, on réaffiche le formulaire.
                */
                require_once 'view/posts/create.php';
                exit();
            }

        } else {
            /*
                Si la personne n'est pas connectée, on la redirige.
            */
            header('Location: index.php?action=showLogin');
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
$posts = getAllPosts($pdo);

/*
    On affiche la vue principale.
*/
require_once 'view/posts/post.php';
?>
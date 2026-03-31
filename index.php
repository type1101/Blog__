<?php
/*
    ============================================================
    FICHIER : index.php
    RÔLE DU FICHIER :
    Ce fichier est le point d'entrée principal du site.
    C'est le premier fichier lancé lorsque l'on ouvre
    l'application dans le navigateur.

    CE QUE CE FICHIER VA FAIRE :
    - Démarrer la session PHP
    - Appeler le contrôleur principal
    - Laisser le contrôleur organiser le reste

    RAPPEL SUR LA SESSION :
    Une session permet de mémoriser des informations
    d'un utilisateur d'une page à l'autre.
    Par exemple, on peut mémoriser qu'un utilisateur
    est connecté.

    ANALOGIE :
    Si le site était un restaurant, ce fichier serait
    la porte d'entrée principale. Tout visiteur passe
    par ici avant d'être orienté vers la bonne zone.
    ============================================================
*/

/*
    On démarre la session.
    Cette ligne est obligatoire si on veut utiliser $_SESSION.
    Il faut la placer avant tout affichage HTML.
*/
session_start();


/*
    On appelle le contrôleur principal.
    C'est lui qui va décider quoi faire :
    - afficher les posts
    - afficher le formulaire de connexion
    - traiter la connexion
    - afficher le formulaire de création
    - enregistrer un nouveau post
    - gérer la déconnexion
*/

require_once 'config/database.php';

require_once 'models/postModels.php';

require_once 'controllers/postControllers.php';
require_once 'controllers/userControllers.php';


$errorMessage = '';

// Centralisation de TOUS les messages d'erreur (Post et User)
if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 'too_big': $errorMessage = "Le fichier est trop volumineux (10 Mo max)."; break;
        case 'pass_wrong': $errorMessage = "Mot de passe incorrect."; break;
        case 'email_not_found': $errorMessage = "Aucun compte trouvé avec cet email."; break;
        case 'email_exist': $errorMessage = "Cet email est déjà utilisé."; break;
        case 'pass_short': $errorMessage = "Le mot de passe doit faire au moins 6 caractères."; break;
        case 'pass_no_match': $errorMessage = "Les mots de passe ne sont pas identiques."; break;
        case 'empty': $errorMessage = "Veuillez remplir tous les champs."; break;
    }
}


$action = $_GET['action'] ?? 'showPosts';

switch ($action) {
    case 'showCreate':
        require_once 'view/posts/create.php';
        break;
    case 'showLogin':
        require_once 'view/users/login.php';
        break;
    case 'showRegister':
        require_once 'view/users/register.php';
        break;

    default:
        $posts = getAllPosts($pdo);
        require_once 'view/posts/post.php';
        break;
}

/*
if (isset($_GET['action']) && $_GET['action'] == 'showCreate') {
    require_once 'view/posts/create.php';
} 
else {
    $posts = getAllPosts($pdo);
    require_once 'view/posts/post.php';
}
?>
*/
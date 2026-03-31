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

require_once 'controllers/postControllers.php';
require_once 'controllers/userControllers.php';

$action = $_GET['action'] ?? 'showPosts';

switch ($action) {
    case 'showCreate':
        require_once 'view/posts/create.php';
        break;
    
    default:
        $posts = getAllPosts($pdo);
        require_once 'view/posts/post.php';
        break;
}
?>
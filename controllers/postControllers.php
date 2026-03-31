<?php
require_once 'models/postModels.php';

$errorMessage = '';

/*
    --------------------------------------------------------
    FORMULAIRE DE CRÉATION DE POST
    --------------------------------------------------------
*/
if (isset($_POST['action']) && $_POST['action'] == 'createPost') {

    /*
        On vérifie que l'utilisateur est connecté.
    */
    if (isset($_SESSION['user'])) {

        /*
            On récupère les données du formulaire.
        */
        $title = trim($_POST['title']);
        $content = trim($_POST['content']);
        $media = null;
        $maxSizeFile = 10 * 1024 * 1024;
        /*
            On récupère l'identifiant de l'utilisateur connecté.
        */
        $user_id = $_SESSION['user']['id'];

        if (isset($_FILES['media']) && $_FILES['media']['error'] == 0) {
            if ($_FILES['media']['size'] > $maxSizeFile) {
                $errorMessage = "Le fichier est trop volumineux";
                require_once 'view/posts/create.php';
                exit();
            }

            $uploadDir = 'uploads/';
            
            if (!is_dir($uploadDir)){
                mkdir($uploadDir, 0777, true);
            }

            $fileExtension = strtolower(pathinfo($_FILES['media']['name'], PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'mov'];
            if (in_array($fileExtension, $allowedExtensions)){
                $extension = pathinfo($_FILES['media']['name'], PATHINFO_EXTENSION);
                $fileName = uniqid('', true) . '.' . $extension;
                $uploadPath = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['media']['tmp_name'], $uploadPath)) {
                    $media = $uploadPath;
                }
            }
        }  
        if ($title != '' && $content != '') {
            createPost($pdo, $title, $content, $media, $user_id);
            header('Location: index.php');
            exit();
        }
    } else {
        header('Location: index.php?action=showLogin');
        exit();
    }
}

/*
    --------------------------------------------------------
    SUPPRESSION D'UN POST
    --------------------------------------------------------
*/
if (isset($_GET['action']) && $_GET['action'] == 'deletePost') {

    /*
        On vérifie que l'utilisateur est connecté.
    */
    if (isset($_SESSION['user'])) {

        /*
            On récupère l'ID du post à supprimer.
        */
        $post_id = isset($_GET['post_id']) ? (int)$_GET['post_id'] : null;

        if ($post_id) {
            /*
                On appelle la fonction de suppression.
                Elle vérifie aussi que l'utilisateur est propriétaire du post.
            */
            $deleted = deletePost($pdo, $post_id, $_SESSION['user']['id']);

            if ($deleted > 0) {
                /*
                    La suppression a réussi.
                    On redirige vers l'accueil.
                */
                header('Location: index.php');
                exit();
            }
        }
    } else {
        header('Location: index.php?action=showLogin');
        exit();
    }
}
?>
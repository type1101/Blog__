<?php
require_once 'models/postModels.php';

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
            /*
                On récupère l'identifiant de l'utilisateur connecté.
            */
            $user_id = $_SESSION['user']['id'];

            if (isset($_FILES['media']) && $_FILES['media']['error'] == 0) {
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
?>
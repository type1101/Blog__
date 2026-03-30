<?php
require_once 'models/postModels.php';

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
?>
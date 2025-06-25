<?php
session_start();

include_once "libs/maLibUtils.php";

$url = valider("url"); // récupération de l'url

$url = explode('/', $url, 2);
$view = $url[0]; // Récupération de la view (racine)
// S'il est vide, on charge la vue accueil par défaut
if (!$view) {
    header("Location:accueil");
    die("");
}

if (count($url) > 1) {
    $data = explode('/', $url[1]); // Récupération des données (reste de l'URL)
} else {
    $data = null;
}

// Gestion des appels AJAX
if ($view == 'api') {
    switch ($data[0]) {
        case 'listerObjet':
            break;
        
        default:
            // on a pas reconnue ce qui est demandé

            break;
    }
    die(); // Pour ne pas 
}


// Gestion de l'appel à view
$mainpage = "templates/500.php";
$title = "Erreur 500";

switch ($view) {
    case "accueil":
        $mainpage = "templates/accueil.php";
        $title = "Accueil";
        break;

    case "apropos":
        $mainpage = "templates/aPropos.php";
        $title = "À propos";
        break;

    case "catalogue":
        $mainpage = "templates/catalogue.php";
        $title = "Catalogue";
        break;

    case "login":
        $mainpage = "templates/login.php";
        $title = "Connexion";
        break;

    case "annonce":
        if (is_null($data)) {
            // on cherche à aller à une annonce, sans préciser laquelle...
            $mainpage = "templates/404.php";
            $title = "Erreur 404";
            break;
        }
        if (count($data) > 1 && $data[1] == "edit") {
            $mainpage = "templates/editionObjet.php";
            $title = "Édition de \"Nom de l'objet ici\""; // TODO
        } else {
            $mainpage = "templates/ficheObjet.php";
            $title = "Nom de l'objet ici"; // TODO
        }
        break;

    case "profil":
        if (is_null($data)) {
            // On cherche à aller à un profil, sans préciser lequel...
            // TODO: Il faut donner une valeur par défaut ici !
            // idée: si l'utilisateur est connecté, on redirige vers son profil, et sinon on redirige vers login ?
            $mainpage = "templates/404.php";
            $title = "Erreur 404";
            break;
        }
        if (count($data) > 1 && $data[1] == "edit") {
            $mainpage = "templates/editionUtilisateur.php";
            $title = "Édition du profil de \"Nom de la personne ici\""; // TODO
        } else {
           $mainpage = "templates/profilUtilisateur.php";
           $title = "Profil de \"Nom de la personne ici\""; // TODO
        }
        break;

    default:
        $mainpage = "templates/404.php";
        $title = "Erreur 404";
}

include("index.php");
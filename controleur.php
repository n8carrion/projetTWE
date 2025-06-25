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

$mainpage = "templates/500.php";

switch ($view) {
    case "accueil":
        $mainpage = "templates/accueil.php";
        break;

    case "apropos":
        $mainpage = "templates/aPropos.php";
        break;

    case "catalogue":
        $mainpage = "templates/catalogue.php";
        break;

    case "login":
        $mainpage = "templates/login.php";
        break;

    case "annonce":
        if (is_null($data)) {
            // on cherche à aller à une annonce, sans préciser laquelle...
            $mainpage = "templates/404.php";
            break;
        }
        if (count($data) > 1 && $data[1] == "edit") {
            $mainpage = "templates/editionObjet.php";
        } else {
            $mainpage = "templates/ficheObjet.php";
        }
        break;

    case "profil":
        if (is_null($data)) {
            // On cherche à aller à un profil, sans préciser lequel...
            // TODO: Il faut donner une valeur par défaut ici !
            // idée: si l'utilisateur est connecté, on redirige vers son profil, et sinon on redirige vers login ?
            $mainpage = "templates/404.php";
            break;
        }
        if (count($data) > 1 && $data[1] == "edit") {
            $mainpage = "templates/editionUtilisateur.php";
        } else {
           $mainpage = "templates/profilUtilisateur.php";
        }
        break;

    default:
        $mainpage = "templates/404.php";
}

include("index.php");
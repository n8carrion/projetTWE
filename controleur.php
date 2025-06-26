<?php
session_start();

include_once "libs/maLibUtils.php";
include_once("libs/maLibSecurisation.php");
include_once("libs/modele.php");

$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/'; // Récupération de la base du serveur

$url = valider("url"); // récupération de l'url

// Enlever le dernier "/" et rediriger si il y en a un
if ($url && mb_substr($url, -1)=="/") {
    header("Location:".$base.substr($url, 0, -1));
    die("");
}

$url = explode('/', $url, 2);
$view = $url[0]; // Récupération de la view (racine)
// S'il est vide, on charge la vue accueil par défaut
if (!$view) {
    header("Location:".$base."accueil");
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
            // Récupère les filtres envoyés en GET
            $categorie = valider('categorie');
            $type = valider('type');
            // Prépare les options pour listerObjets
            $options = [];
            if ($categorie) $options['categorie'] = $categorie;
            if ($type) $options['type'] = $type;
            // Appelle la fonction et renvoie le JSON
            $result = listerObjets($options);
            echo json_encode($result);
            
                
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
        if (is_null($data)) {
            $mainpage = "templates/login.php";
            $title = "Connexion";
        } elseif ($data[0] == "cla") {
            $ticket = valider("ticket"); // Ce ticket n'est valide que 15 secondes !
            if (!$ticket) {
                $mainpage = "templates/404.php";
                $title = "Erreur 404";
                break;
            }
            $q = verifUserCLA($ticket);
            header('Location: '.$base.$q);
            die();
        } elseif ($data[0] == "fix") {
            include_once("config.php");
            if ($PROD) {
                $mainpage = "templates/404.php";
                $title = "Erreur 404";
                break;
            }
            fixtureLogin($data[1]);
            header('Location: '.$base."accueil");
            die();
        }
        break;

    case "annonce": // TODO : mettre en place l'authentification
        if (is_null($data)) {
            // on cherche à aller à une annonce, sans préciser laquelle...
            $mainpage = "templates/404.php";
            $title = "Erreur 404";
        } elseif (count($data) > 1 && $data[1] == "edit") {
            $idObjet = $data[0];
            $mainpage = "templates/editionObjet.php";
            $title = "Édition de \"Nom de l'objet ici\""; // TODO
        } elseif ($data[0] == "") {
            $mainpage = "templates/404.php";
            $title = "Erreur 404";
        } else {
            $idObjet = $data[0];
            $mainpage = "templates/ficheObjet.php";
            $title = "Nom de l'objet ici"; // TODO
        }
        break;

    case "profil":
        if (is_null($data) || $data[0]=="edit") {
            // On cherche à aller à un profil, sans préciser lequel...
            // Si l'utilisateur est connecté, on redirige vers son profil, et sinon on redirige vers login
            if (valider("connecte","SESSION")) {
                if (!is_null($data) && $data[0]=="edit") {
                    $data = [valider("idUser","SESSION"), "edit"]; // Cela va à terme rediriger vers le profil de la personne en mode édition
                } else {
                    $data = [valider("idUser","SESSION")]; // Cela va à terme rediriger vers le profil de la personne
                }
            } else {
                header('Location: '.$base.'login');
                die();
            }
        }
        if (is_numeric($data[0])) {
            $idProfil = $data[0];
            
            if (!($userInfo = infoUtilisateur($idProfil))){
                $mainpage = "templates/404.php";
                $title = "Erreur 404";
                break;
            }
            $userString = $userInfo[0]["prenom"] . " " . $userInfo[0]["nom"];
            if (count($data) > 1 && $data[1] == "edit") {
                if (!valider("connecte","SESSION")) {
                    header('Location: '.$base.'login');
                    die();
                } elseif ($idProfil == valider("idUser", "SESSION") || isModerateur(valider("idUser", "SESSION"))) {
                    $mainpage = "templates/editionUtilisateur.php";
                    $title = "Édition du profil de ".$userString;
                } else {
                    $mainpage = "templates/403.php";
                    $title = "Erreur 403";
                }
            } else {
                $mainpage = "templates/profilUtilisateur.php";
                $title = "Profil de ".$userString;
            }
        }
        break;

    case 'logout':
        session_destroy();
        header('Location: ' . $base . 'accueil');
        die();

    default:
        $mainpage = "templates/404.php";
        $title = "Erreur 404";
}

include("index.php");
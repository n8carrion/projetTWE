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
            $amount = valider('amount');
            $sort = valider('sort');
            $utilisateur = valider('utilisateur');
            
            // Prépare les options pour listerObjets
            $options = [];
            if ($categorie) $options['categorie'] = $categorie;
            if ($type) $options['type'] = $type;
            if ($amount) $options['amount'] = $amount;
            if ($sort) $options['sort'] = $sort;
            if ($utilisateur) $options['utilisateur'] = $utilisateur;
            // Appelle la fonction et renvoie le JSON
            $result = listerObjets($options);
            echo json_encode($result);
            
                
            break;
        case 'supprimerObjet':
            // Suppression d'un objet
            //c'est ce qu'on lui donne comme idObjet
            // on vérifie que l'utilisateur est connecté et qu'il a le droit de supprimer l'objet
            // if (!valider("connecte", "SESSION")) {
            //     echo json_encode(["success" => false, "error" => "Vous devez être connecté pour supprimer un objet."]);
            //     die();
            // }
            $idObjet = valider("idObjet");
            if (is_numeric($idObjet)) {
                $result = supprimerObjet($idObjet);
                echo($result);
            } 
            else{
                echo("erreur controleur pour suppression annonce");
            }

            break;
        case 'suggestionsObjets':
            $debutNom = valider('debutNom');
            $result = suggestionsObjets($debutNom);
            echo json_encode($result);
        exit;
        
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

    case "annonce": // base/annonce*
        if (is_null($data)) { // base/annonce
            // on cherche à aller à une annonce, sans préciser laquelle...
            $mainpage = "templates/404.php";
            $title = "Erreur 404";
        } elseif ($data[0]=="edit") { // base/annonce/edit
            // On cherche à éditer une annonce sans préciser laquelle : Création d'une nouvelle annonce
            if (valider("connecte","SESSION")) {
                $idObjet = -1;
                $mainpage = "templates/editionObjet.php";
                $title = "Nouvelle annonce";
            } else {
                header('Location: '.$base.'login');
                die();
            }
        } elseif ($data[0] != "" && is_numeric($data[0]) && count($data) <= 2) { // base/annonce/#/*
            $idObjet = $data[0];

            // on vérifie si l'id correspond bien à un objet
            if (!($objetInfo = infoObjet($idObjet))){
                $mainpage = "templates/404.php";
                $title = "Erreur 404";
                break;
            }

            // si l'objet est archivé, on vérifie que l'utilisateur est connecté, et qu'il est soit propriétaire, soit modérateur
            if ($objetInfo[0]["statutObjet"] == "Archive" && !(valider("connecte", "SESSION") && (isModerateur(valider("idUser", "SESSION")) || valider("idUser", "SESSION") == $objetInfo[0]["idProprietaire"]))) {
                $mainpage = "templates/403.php";
                $title = "Erreur 403";
                break;
            }

            $objetString = $objetInfo[0]["nom"];
            
            if (count($data) == 2 && $data[1] == "edit") { // base/annonce/#/edit
                if (!valider("connecte","SESSION")) {
                    header('Location: '.$base.'login');
                    die();
                } elseif ($objetInfo[0]["idProprietaire"] == valider("idUser", "SESSION") || isModerateur(valider("idUser", "SESSION"))) {
                    $mainpage = "templates/editionObjet.php";
                    $title = "Édition de l'annonce \"".$objetString.'"';
                } else {
                    $mainpage = "templates/403.php";
                    $title = "Erreur 403";
                }
            } else { // base/annonce/#
                $mainpage = "templates/ficheObjet.php";
                $title = $objetString;
            }
        } else {
            $mainpage = "templates/404.php";
            $title = "Erreur 404";
        }
        break;

    case "profil":
        if (is_null($data) || $data[0]=="edit") { // base/profil ou base/profil/edit
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
        if ($data[0] != "" && is_numeric($data[0]) && count($data) <= 2) { // base/profil/#/*
            $idProfil = $data[0];
            
            // on vérifie si l'id correspond bien à un utilisateur
            if (!($userInfo = infoUtilisateur($idProfil))){
                $mainpage = "templates/404.php";
                $title = "Erreur 404";
                break;
            }

            $userString = $userInfo[0]["prenom"] . " " . $userInfo[0]["nom"];

            if (count($data) == 2 && $data[1] == "edit") { // base/profil/#/edit
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
            } else { // base/profil/#
                $mainpage = "templates/profilUtilisateur.php";
                $title = "Profil de ".$userString;
            }
        } else {
            $mainpage = "templates/404.php";
            $title = "Erreur 404";
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
<?php
session_start();

include_once "libs/maLibUtils.php";

/*
Cette page génère les différentes vues de l'application en utilisant des templates situés dans le répertoire "templates". Un template ou 'gabarit' est un fichier php qui génère une partie de la structure XHTML d'une page. 

La vue à afficher dans la page index est définie par le paramètre "view" qui doit être placé dans la chaîne de requête. En fonction de la valeur de ce paramètre, on doit vérifier que l'on a suffisamment de données pour inclure le template nécessaire, puis on appelle le template à l'aide de la fonction include

Les formulaires de toutes les vues générées enverront leurs données vers la page data.php pour traitement. La page data.php redirigera alors vers la page index pour réafficher la vue pertinente, généralement la vue dans laquelle se trouvait le formulaire. 
*/

$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/'; // récupération de la base du serveur
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15" />
	<base href="<?= $base ?>">
	<title>La REZerve</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>

<?php

// récupération du paramètre de vue
//$view = valider("view");
$url = valider("url"); // récupération de l'url

echo "url:". $url;

$url = explode('/', $url);
$view = $url[0];
echo ", view:". $view;
// S'il est vide, on charge la vue accueil par défaut
if (!$view) $view = "accueil";

// Affichage dans tous les cas du header
include("templates/header.php");

switch ($view) {
	case "accueil":
		include("templates/accueil.php");
		break;

	case "apropos":
		include("templates/aPropos.php");
		break;
	
	case "catalogue":
		include("templates/catalogue.php");
		break;
	
	case "login":
		include("templates/login.php");
		break;

	default:
		include("templates/404.php");
}

// Dans tous les cas, on affiche le pied de page
include("templates/footer.php");
?>
</body>
</html>
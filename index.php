<?php
session_start();

include_once "libs/maLibUtils.php";

/*
Cette page génère les différentes vues de l'application en utilisant des templates situés dans le répertoire "templates". Un template ou 'gabarit' est un fichier php qui génère une partie de la structure XHTML d'une page. 

La vue à afficher dans la page index est définie par le paramètre "view" qui doit être placé dans la chaîne de requête. En fonction de la valeur de ce paramètre, on doit vérifier que l'on a suffisamment de données pour inclure le template nécessaire, puis on appelle le template à l'aide de la fonction include

Les formulaires de toutes les vues générées enverront leurs données vers la page data.php pour traitement. La page data.php redirigera alors vers la page index pour réafficher la vue pertinente, généralement la vue dans laquelle se trouvait le formulaire. 
*/

// récupération du paramètre de vue
//$view = valider("view");
$url = valider("url"); // récupération de l'url

$url = explode('/', $url, 2);
$view = $url[0]; // Récupération de la view (racine)
// S'il est vide, on charge la vue accueil par défaut
if (!$view) {
	header("Location:accueil");
	die("");
}

if (count($url) > 1) {
	$data = $url[1]; // Récupération des données (reste de l'URL)
} else {
	$data = null;
}


$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/'; // récupération de la base du serveur
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15" />
	<base href="<?= $base ?>">
	<title>La REZerve</title>

	<link rel="apple-touch-icon" sizes="57x57" href="ressources/icons/favicon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="ressources/icons/favicon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="ressources/icons/favicon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="ressources/icons/favicon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="ressources/icons/favicon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="ressources/icons/favicon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="ressources/icons/favicon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="ressources/icons/favicon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="ressources/icons/favicon-180x180.png">
	<link rel="icon" type="image/png" sizes="16x16" href="ressources/icons/favicon-16x16.png">
	<link rel="icon" type="image/png" sizes="32x32" href="ressources/icons/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="ressources/icons/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="192x192" href="ressources/icons/favicon-192x192.png">
	<link rel="shortcut icon" type="image/x-icon" href="ressources/icons/favicon.ico">
	<link rel="icon" type="image/x-icon" href="ressources/icons/favicon.ico">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="ressources/icons/favicon-144x144.png">
	<meta name="msapplication-config" content="ressources/icons/browserconfig.xml">

	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>

	<?php

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
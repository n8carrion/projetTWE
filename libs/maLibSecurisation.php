<?php

include_once "maLibUtils.php";	// Car on utilise la fonction valider()
include_once "modele.php";	// Car on utilise la fonction connecterUtilisateur()

/**
 * @file login.php
 * Fichier contenant des fonctions de vérification de logins
 */

/**
 * Cette fonction vérifie si le ticket CLA est légal
 * Si oui, elle regarde si l'utilisateur doit existe déjà
 * Si ce n'est pas le cas, création de l'utilisateur
 * Elle stocke les informations sur la personne dans des variables de session : session_start doit avoir été appelé...
 * Infos à enregistrer : idUser, isModerator
 * Elle enregistre l'état de la connexion dans une variable de session "connecte" = true
 * @param string $ticketCLA
 * @param string $password
 * @return string $q ; là où doit être redirigé l'utilisateur
 */

function verifUserCLA($ticketCLA)
{
	$url = "https://centralelilleassos.fr/authentification/larezerve/" . urlencode($ticketCLA);

	$options = [
		'http' => [
			'ignore_errors' => true
		]
	];
	$context = stream_context_create($options);
	$response = file_get_contents($url, false, $context);
	$data = json_decode($response, true);

	if (!$data || !$data['success']) {
		die("Échec de l'authentification."); // TODO : remove
	}

	// Information de l'utilisateur
	$payload = $data['payload'];
	$username = $payload['username'];
	$firstName = $payload['firstName'];
	$lastName = $payload['lastName'];
	$email = $payload['emailSchool'];
	//$cursus = $payload['cursus']; // non utilisé
	
	$q = "accueil";
	if (!($idUser = existUserCLA($username))) {
		$idUser = creerUtilisateur($lastName, $firstName, $username, $email);
		$q = "profil/edit";
	}

	// Ouvrir une session
	$_SESSION['connecte'] = true;
	$_SESSION['idUser'] = $idUser;
	$_SESSION['isModerator'] = isModerateur($idUser);

	return $q;
}

function fixtureLogin($pseudoCLA) {
	if (!($idUser = existUserCLA($pseudoCLA))) {
		die("User does not exist");
	}

	// Ouvrir une session
	$_SESSION['connecte'] = true;
	$_SESSION['idUser'] = $idUser;
	$_SESSION['isModerator'] = isModerateur($idUser);
}


/**
 * Fonction à placer au début de chaque page privée
 * Cette fonction redirige vers la page $urlBad en envoyant un message d'erreur 
	et arrête l'interprétation si l'utilisateur n'est pas connecté
 * Elle ne fait rien si l'utilisateur est connecté, et si $urlGood est faux
 * Elle redirige vers urlGood sinon
 */
function securiser($urlBad,$urlGood=false)
{

}

?>

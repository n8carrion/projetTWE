<?php

/*
Dans ce fichier, on définit diverses fonctions permettant de récupérer des données utiles pour notre TP d'identification. Deux parties sont à compléter, en suivant les indications données dans le support de TP


CRUD d'une entité : fonctions de manipulation basique d'une entité 
C <=> Create : INSERT INTO 
R <=> Read : SELECT 
U <=> Update : UPDATE 
D <=> Delete : DELETE 


*/


// inclure ici la librairie faciliant les requêtes SQL (en veillant à interdire les inclusions multiples)

include_once("libs/maLibSQL.pdo.php");


function listerUtilisateurs($classe = "both")
{
	// Cette fonction liste les utilisateurs de la base de données 
	// et renvoie un tableau d'enregistrements. 
	// Chaque enregistrement est un tableau associatif contenant les champs 
	// id,pseudo,blacklist,couleur

	// Lorsque la variable $classe vaut "both", elle renvoie tous les utilisateurs
	// Lorsqu'elle vaut "bl", elle ne renvoie que les utilisateurs blacklistés
	// Lorsqu'elle vaut "nbl", elle ne renvoie que les utilisateurs non blacklistés

	$SQL = "select * from users";
	if ($classe=="bl")  $SQL = $SQL . " WHERE blacklist=1"; 
	if ($classe=="nbl") $SQL .= " WHERE blacklist=0";
	
	$SQL .= " ORDER BY blacklist ASC";
	
	// echo $SQL; 
	// $res = SQLSelect($SQL); 
	// $res est un recordset : objet PDO contenant les infos
	// $tab = parcoursRs($res);
	return parcoursRs(SQLSelect($SQL));

}

function interdireUtilisateur($idUser)
{
	// cette fonction affecte le booléen "blacklist" à vrai 
	$SQL ="UPDATE users SET blacklist=1 WHERE id='$idUser'"; 
	SQLUpdate($SQL); 
}

function supprimerUtilisateur ($idUser) {
	$SQL = "DELETE FROM users WHERE id='$idUser'";
	SQLDelete($SQL);
}

function autoriserUtilisateur($idUser)
{
	// cette fonction affecte le booléen "blacklist" à faux 
	// contre mesures contre les injections SQL : 
	// 1) Utiliser des requetes préparées : équivalent d'un printf avec des arguments 
	// executerSQL("requete (%s,%s)", arg1, arg2)
	// 2) : encadrer les arguments par des apostrophes 
	// => insuffisant !! on peut injecter aussi des apostrophes
	// 2bis) banaliser les caractères dangereux (notamment les apostrophes) 
	// => utiliser addslashes (déjà appelée dans la fonction valider) 
	
	$SQL ="UPDATE users SET blacklist=0 WHERE id='$idUser'"; 
	
	SQLUpdate($SQL); 
}

/********* EXERCICE 4 *********/

function verifUserBdd($login,$passe)
{
	// Vérifie l'identité d'un utilisateur 
	// dont les identifiants sont passes en paramètre
	// renvoie faux si user inconnu
	// renvoie l'id de l'utilisateur si succès
	
	$SQL = "SELECT id FROM users"; 
	$SQL .= " WHERE pseudo='$login' AND passe='$passe'";
	
	// $tab = parcoursRs(SQLSelect($SQL)) ;
	// if (count($tab)) return $tab[0]["id"]; 
	// else return false;
	return SQLGetChamp($SQL); 
	
		// On utilise SQLGetChamp
	// si on avait besoin de plus d'un champ
	// on aurait du utiliser SQLSelect
	
	
	// Attention à la protection du champ passe ! 
	// Il est préférable de crypter le champ passe  
	// $SQL .= " WHERE pseudo='$login' AND passe=crypt('$passe')";



}

function isAdmin($idUser)
{
	// vérifie si l'utilisateur est un administrateur
	$SQL = "SELECT admin FROM users WHERE id='$idUser'";
	return SQLGetChamp($SQL);
}



?>

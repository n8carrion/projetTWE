<?php
include_once("libs/maLibSQL.pdo.php") ;

//Fonctions Utilisateurs
function creerUtilisateur($nom, $prenom, $passe,$mail,$tel,$adresse,$facebook,$statut) {
  $SQL = "INSERT INTO Utilisateur(nom, prenom, passeHash, mail, telephone, adresse, facebook, statutUtilisateur)" ;
  $SQL .= " VALUES ('$nom','$prenom','$passe','$mail','$tel','$adresse','$facebook','$statut')" ;

  return SQLInsert($SQL) ;
}

function ListerObjetsASoi($idProprietaire) {
  //Renvoie le tableau d'objets (objets JSON)
  //relatif à l'utilisateur d'id idProprietaire
  $SQL = "SELECT o.* from Objet o" ;
  $SQL .= " INNER JOIN Utilisateur u ON o.idProprietaire = u.id" ;
  $SQL .= " WHERE o.idProprietaire = '$idProprietaire'" ;

  return parcoursRs(SQLSelect($SQL)) ;
}
function listerUtilisateur($statut="both") {
  //Renvoie le tableau des utilisateurs dont 
  //le statut est spécifié en paramètres
  //Soit étudiant ou modérateur
  $SQL = "SELECT * from Utilisateur" ;
  if ($statut=="etudiant") $SQL .= " WHERE statutUtilisateur='etudiant'" ;
  if ($statut=="moderateur") $SQL .= " WHERE statutUtilisateur='moderateur'" ;
  return parcoursRs(SQLSelect($SQL)) ;
}

function verifUserBdd($login,$passe)
{
	// Vérifie l'identité d'un utilisateur 
	// dont les identifiants sont passes en paramètre
	// renvoie faux si user inconnu
	// renvoie l'id de l'utilisateur si succès
	
	$SQL = "SELECT id FROM Utilisateur"; 
	$SQL .= " WHERE mail='$login' AND passeHash='$passe'";
	
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
function isModerateur ($idUtilisateur) {
  //Verifie que l'utilisateur est modérateur
  //cela lui donne ainsi les droits d'édition
  //de tout le catalogue
  $SQL = "SELECT statutUtilisateur FROM Utilisateur" ;
  $SQL .= " WHERE id='$idUtilisateur'" ;
  return SQLGetChamp($SQL) === 'moderateur' ; //pour avoir un booléen
}

function setModerateur($idUtilisateur) {
  //change le statut de l'utilisateur en moderateur lui donnant davantage de droits
  $SQL = " UPDATE Utilisateur SET statutUtilisateur='moderateur'" ;
  $SQL .= " WHERE id='$idUtilisateur'" ;
  SQLUpdate($SQL) ;
}

//Fonctions Images

function getImagesbyObject($idObjet) {
  //Renvoie le tableau d'images (objets JSON)
  //relatif à l'objet d'id idObjet
  $SQL = "SELECT i.* FROM Image i" ;
  $SQL .= " INNER JOIN Objet o ON i.idObjet= o.id";
  $SQL .= " WHERE i.idObjet = '$idObjet'" ;

  return parcoursRS(SQLSelect($SQL)) ;
}

function supprimerImage($idImage) {
  $SQL = "DELETE FROM Image WHERE id='$idImage'" ;
  SQLDelete($SQL);
}

function choisirImage($idObjet, $idImage) {
  //Retourne l'objet JSON représentant l'image donnée 
  // dont $idImage est en paramètres
  // associée à l'objet dont l'id est $idObjet
$SQL = "SELECT i.* FROM Image i";
$SQL .= " INNER JOIN Objet o ON i.idObjet= o.id";
$SQL .= " WHERE i.idObjet = '$idObjet' AND i.id='$idImage'";

return parcoursRS(SQLSelect($SQL)) ;
}

/*
Fonctions pour les objets :
  fonction ajouterObjet($data)
  Insert into Objets(champs)
  fonction modifierObjet(idProprietaire)
  fonction changerStatutObjet()
  fonction suprimerObjet(idObjet)
  DELETE * from Objets WHERE Objets.id = idObjets
  fonction choisirImage(idObjet, idImage)
  fonction ListerObjets(categorie, type)
  (pour savoir quoi afficher) dans le catalogue)
  elle renvoi un objet JSON qui contient un tableau avec les objets json des objets qui correspondent à la catégorie et au type donné : { “tabObjets” : [{JSONobjet1}, {JSONobjet2}, {JSONobjet3}]}
  $data[“tabObjets”] = array();
  $SQL = “SELECT * FROM Objet WHERE categorieObjet = categorie AND typeAnnonce = type”;
  $result = parcoursRS(SQLSelect($SQL));
  $data[“tabObjets”] = $result
  return json_encode($data);



  Fonctions pour les utilisateurs :
  fonction lister Utilisateur(class=”both”) //étudiant ou association
  Fonction modifierUtilisateur()
  fonction creerUtilisateur()
  Fonction ListerObjetsASoi(idPrioprietaire)
  Fonction ListerObjetsCategorie()
  Fonction supprimerUtilisateur() pour le modérateur

  Fonctions pour les images:
  uploadImages(idObjet, images) ne renvoit rien mais permet d’upload les images pour l’annonce d’un objet
  getImagesByObjet(idObjet), renvoi un tableau avec le nom des images pour un objet
  suprimerImage
*/

?>
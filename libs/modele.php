<?php
include_once("libs/maLibSQL.pdo.php") ;

//parcoursRs() renvoie un tableau assocaitif
//il faudra utiliser json_encode() pour le convertir en objet JSON

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
  //Soit étudiant ou modérateur, par défaut les deux si rien n'est donné à la fonction
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

function infoUtilisateur($idUtilisateur) {
  $SQL = "SELECT * from Utilisateur" ;
  $SQL .= " WHERE id='$idUtilisateur'" ;
  return parcoursRs(SQLSelect($SQL)) ;
}

//Fonctions Images

function getImagesbyObjet($idObjet) {
  //Renvoie le tableau d'images (objets JSON)
  //relatif à l'objet d'id idObjet
  $SQL = "SELECT i.* FROM Image i" ;
  $SQL .= " INNER JOIN Objet o ON i.idObjet= o.id";
  $SQL .= " WHERE i.idObjet = '$idObjet'" ;

  return parcoursRs(SQLSelect($SQL)) ;
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

return parcoursRs(SQLSelect($SQL)) ;
}


// Fonctions pour les objets :

//La fonction creerObjet permet de d'ajouter un objet dans la base de données en lui donnant ses infos 
//(sauf id et dateCreation qui sont généré  automatiquement pas la base de données. )
function creerObjet($nom, $idProprietaire, $description, $typeAnnonce, $statutObjet, $categorie) {
  //Crée un objet dans la base de données
  //et retourne l'id de l'objet créé

  //Pour éviter les injestion de html il faut encoder les caractères spéciaux HTML :
  $nom = htmlspecialchars($nom);
  $description = htmlspecialchars($description);

  $SQL = "INSERT INTO Objet(nom, idProprietaire, description, typeAnnonce, statutObjet, categorieObjet)" ;
  $SQL .= " VALUES ('$nom','$idProprietaire','$description','$typeAnnonce','$statutObjet','$categorie')" ;

  return SQLInsert($SQL) ;
}

//   La fonction modifierObjet(idProprietaire) permet de modifier un objet dans la base de données
// tous les paramètres doivent être donnés : idObjet, nom, description, typeAnnonce, statutObjet et categorieObjet
//   elle ne modifie pas l'id de l'objet ni la date de création 
function modifierObjet($idObjet, $nom, $description, $typeAnnonce, $statutObjet, $categorieObjet) {
  //Modifie un objet dans la base de données et retourne l'id de l'objet modifié

  //Pour éviter les injestion de html il faut encoder les caractères spéciaux HTML :
  $nom = htmlspecialchars($nom);
  $description = htmlspecialchars($description);

  $SQL = "UPDATE Objet SET nom='$nom', description='$description', typeAnnonce='$typeAnnonce', statutObjet='$statutObjet', categorieObjet='$categorie'" ;
  $SQL .= " WHERE id='$idObjet'" ;

  SQLUpdate($SQL) ;
}
  
//   La fonction suprimerObjet(idObjet) permet de supprimer un objet de la base de données
function supprimerObjet($idObjet) {
  $SQL = "DELETE FROM Objet WHERE id='$idObjet'" ;
  SQLDelete($SQL);
}


//   fonction ListerObjets(....) permet de lister les objets de la base de données
//   en fonction de plusieurs paramètres : 
//   - categorie (string) : catégorie de l'objet
//   - type (string) : don ou emprunt
//   - utilisateur (int) : id du propriétaire de l'objet
//   - statut (string) : satut de l'objet
//   - amount (int) : nombre d'objets à retourner
//   - sort (string) : tri des objets par date de création (recent ou ancien
// si on lui donne aucun paramètre, on liste tous les objets de la table Objet

function listerObjets($options = array()) {
    // la tableau associatif $options peut contenir : 
    // 'categorie', 'type', 'utilisateur', 'statut', 'amount', 'sort'
    $SQL = "SELECT id FROM Objet WHERE 1=1"; //toujours vrai, donc permet de tout selectionner

    // Filtrage par catégorie
    if (!empty($options['categorie'])) {
        $categorie = htmlspecialchars($options['categorie']); // permet d'éviter les injections SQL
        $SQL .= " AND categorieObjet='$categorie'";
    }

    // Filtrage par type
    if (!empty($options['type'])) {
        $type = htmlspecialchars($options['type']);
        $SQL .= " AND typeAnnonce='$type'";
    }

    // Filtrage par utilisateur/propriétaire
    if (!empty($options['utilisateur'])) {
        $utilisateur = intval($options['utilisateur']);
        $SQL .= " AND idProprietaire='$utilisateur'";
    }

    // Filtrage par statut
    if (!empty($options['statut'])) {
        $statut = htmlspecialchars($options['statut']);
        $SQL .= " AND statutObjet='$statut'";
    }


    // Tri selon la date de création le plus récent d'abord (DESC)ou le plus ancien(ASC)
    if (!empty($options['sort'])) {
        if ($options['sort'] == "recent") {
            $SQL .= " ORDER BY dateCreation DESC";
        } else if ($options['sort'] == "ancien") {
            $SQL .= " ORDER BY dateCreation ASC";
        } // Ajoute d'autres tris si besoin
    } else {
        $SQL .= " ORDER BY id DESC";
    }

    // Limite le nombre de résultats
    if (!empty($options['amount'])) {
        $amount = intval($options['amount']);
        $SQL .= " LIMIT $amount";
    }

    // Exécution et retour des id des objets correspondants à la requête SQL :
    // parcoursRs() renvoie un tableau associatif avec les résultats de la requête
    $result = parcoursRs(SQLSelect($SQL));
    $ids = array();// c'est le tableau qui contient la liste des id
    foreach ($result as $row) {
        $ids[] = $row['id']; // on ajoute l'id au tableau $ids qui sera retourné par la fonction 
    }
    return $ids;
}


  // Fonctions pour les utilisateurs :
  // fonction lister Utilisateur(class=”both”) //étudiant ou moderateur
  // Fonction modifierUtilisateur()
  // fonction creerUtilisateur()
  // Fonction ListerObjetsASoi(idPrioprietaire)
  // Fonction ListerObjetsCategorie()
  // Fonction supprimerUtilisateur() pour le modérateur

  // Fonctions pour les images:
  // uploadImages(idObjet, images) ne renvoit rien mais permet d’upload les images pour l’annonce d’un objet
  // getImagesByObjet(idObjet), renvoi un tableau avec le nom des images pour un objet
  // suprimerImage


?>
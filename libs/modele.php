<?php
include_once("libs/maLibSQL.pdo.php") ;

//parcoursRs() renvoie un tableau assocaitif
//il faudra ensuite utiliser json_encode() pour le convertir en objet JSON

//===========================
// Fonctions pour les utilisateurs ============================================
//===========================
function creerUtilisateur($nom, $prenom, $pseudoCLA, $mail) {
  $SQL = "INSERT INTO Utilisateur(nom, prenom, pseudoCLA, mail)" ;
  $SQL .= " VALUES ('$nom','$prenom','$pseudoCLA', '$mail')" ;

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

function existUserCLA($pseudoCLA)
{
	// Vérifie l'identité d'un utilisateur 
	// dont le ticket CLA est passé en argument
	// renvoie faux si le ticket ne renvoie rien auprès de CLA
	// sinon, si l'utilisateur existe déjà, 

	$SQL = "SELECT id FROM Utilisateur"; 
	$SQL .= " WHERE pseudoCLA='$pseudoCLA'";
	
	return SQLGetChamp($SQL); 
}

function isModerateur ($idUtilisateur) {
  //Verifie que l'utilisateur est modérateur
  //cela lui donne ainsi les droits d'édition
  //de tout le catalogue
  $SQL = "SELECT statutUtilisateur FROM Utilisateur" ;
  $SQL .= " WHERE id='$idUtilisateur'" ;
  return SQLGetChamp($SQL) === 'Modérateur' ; //pour avoir un booléen
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

//===========================
// Fonctions pour les images ============================================
//===========================

function getImagesByObjet($idObjet) {
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

//===========================
// Fonctions pour les objets ============================================
//===========================


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

//===========================
// Fonctions pour categorie ============================================
//===========================

function getCategorie($idCategorie) {
  $SQL = "SELECT nom from categorie c" ;
  $SQL .= " INNER JOIN Objet o on o.idCategorie = c.id" ;
  $SQL .= " WHERE o.idCategorie='$idCategorie'";
}

//   fonction ListerObjets(....) permet de lister les objets de la base de données
//   en fonction de plusieurs paramètres donné dans un tableau associatif $options: 
//   - categorie (string) : catégorie de l'objet
//   - type (string) : don ou emprunt
//   - utilisateur (int) : id du propriétaire de l'objet
//   - statut (string) : satut de l'objet
//   - amount (int) : nombre d'objets à retourner
//   - sort (string) : tri des objets par date de création (recent ou ancien
// si on lui donne aucun paramètre, on liste tous les objets de la table Objet

// //exemple d'objet JSON pour un objet : (on ne prend pas en compte les prêts)
  // {"id" : 1, 
  // "nom" : "Table basse",
  // "idProprietaire" : 2,
  // "description" : "Table basse en bois",
  // "typeAnnonce" : "don",
  // "statutObjet" : "disponible",
  // "categorieObjet" : "meuble",
  // "dateCreation" : "2023-10-01 12:00:00",
  // "images" : [
  //   {"id": 1, "hash": "exemple1.jpg", "idObjet": 1},
  //   {"id": 2, "hash": "exemple2.jpg", "idObjet": 1}
  // ]
  // }
function listerObjets($options = array()) {
    // la tableau associatif $options peut contenir : 
    // 'categorie', 'type', 'utilisateur', 'statut', 'amount', 'sort'
    $SQL = "SELECT * FROM Objet WHERE 1=1"; //toujours vrai, donc permet de tout selectionner

    // Filtrage par catégorie
    // if (!empty($options['categorie'])) {
    //     $categorie = htmlspecialchars($options['categorie']); // permet d'éviter les injections SQL
    //     $SQL .= " AND categorieObjet='$categorie'";
    // }

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

    // Exécution et retour de tous les objets  correspondants à la requête SQL :
    // parcoursRs() renvoie un tableau associatif avec les résultats de la requête
    //ensuite on pourra faire un json_encode() du resulat pour avoir un tableau d'objet json
    //le tableau contiendra tous les oBjets des objets concernés par les filtres

    //TODO : le tableau renvoyé doit aussi contenir les images associées à chaque objet!!
    $res = parcoursRs(SQLSelect($SQL));

    // Pour chaque objet, on ajoute le champ "images"
    foreach ($res as &$objet) {
        $objet['images'] = getImagesByObjet($objet['id']);
    }
    unset($objet); // bonne pratique pour éviter les effets de bord

    return $res;

  }

  

//La fonction infoObjet(idObjet) renvoie un tableau associatif contenant 
// les informations de l'objet d'ont l'id est passé en paramètre
function infoObjet($idObjet) {
  $SQL = "SELECT * from Objet" ;
  $SQL .= " WHERE id='$idObjet'" ;
  return parcoursRs(SQLSelect($SQL)) ;
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
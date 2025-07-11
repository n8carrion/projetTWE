<?php
include_once("libs/maLibSQL.pdo.php");

//===========================
// Fonctions pour les utilisateurs ============================================
//===========================
function creerUtilisateur($nom, $prenom, $pseudoCLA, $mail)
{
  $SQL = "INSERT INTO Utilisateur(nom, prenom, pseudoCLA, mail)";
  $SQL .= " VALUES ('$nom','$prenom','$pseudoCLA', '$mail')";

  return SQLInsert($SQL);
}

//this version doesnt care for moderator status changes. another function can be created for that
function modifierUtilisateur($idUtilisateur, $mail, $telephone, $adresse, $facebook = "")
{
  //Modifie un utilisateur dans la base de données et retourne l'id de l'utilisateur modifié

  //Pour éviter les injestion de html il faut encoder les caractères spéciaux HTML :
  $mail = htmlspecialchars($mail);
  $telephone = htmlspecialchars($telephone);
  $adresse = htmlspecialchars($adresse);
  //$statutUtilisateur=htmlspecialchars($statutUtilisateur);
  $facebook = htmlspecialchars($facebook);

  $SQL = "UPDATE Utilisateur SET mail='$mail', telephone='$telephone', adresse='$adresse', facebook='$facebook'";
  $SQL .= " WHERE id='$idUtilisateur'";

  SQLUpdate($SQL);
}

function supprimerUtilisateur($idUtilisateur)
{
  $SQL = "DELETE FROM Utilisateur WHERE id='$idUtilisateur'";
  SQLDelete($SQL);
}

function ListerObjetsASoi($idProprietaire)
{
  //Renvoie le tableau d'objets (objets JSON)
  //relatif à l'utilisateur d'id idProprietaire
  $SQL = "SELECT o.* from Objet o";
  $SQL .= " INNER JOIN Utilisateur u ON o.idProprietaire = u.id";
  $SQL .= " WHERE o.idProprietaire = '$idProprietaire'";

  return parcoursRs(SQLSelect($SQL));
}
function listerUtilisateur($statut = "both")
{
  //Renvoie le tableau des utilisateurs dont 
  //le statut est spécifié en paramètres
  //Soit étudiant ou modérateur, par défaut les deux si rien n'est donné à la fonction
  $SQL = "SELECT * from Utilisateur";
  if ($statut == "etudiant") $SQL .= " WHERE statutUtilisateur='etudiant'";
  if ($statut == "moderateur") $SQL .= " WHERE statutUtilisateur='moderateur'";
  return parcoursRs(SQLSelect($SQL));
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

function isModerateur($idUtilisateur)
{
  //Verifie que l'utilisateur est modérateur
  //cela lui donne ainsi les droits d'édition
  //de tout le catalogue
  $SQL = "SELECT statutUtilisateur FROM Utilisateur";
  $SQL .= " WHERE id='$idUtilisateur'";
  return SQLGetChamp($SQL) === 'Modérateur'; //pour avoir un booléen
}

function setModerateur($idUtilisateur)
{
  //change le statut de l'utilisateur en moderateur lui donnant davantage de droits
  $SQL = " UPDATE Utilisateur SET statutUtilisateur='moderateur'";
  $SQL .= " WHERE id='$idUtilisateur'";
  SQLUpdate($SQL);
}

function infoUtilisateur($idUtilisateur)
{
  $SQL = "SELECT * from Utilisateur";
  $SQL .= " WHERE id='$idUtilisateur'";
  return parcoursRs(SQLSelect($SQL));
}

//===========================
// Fonctions pour les images ============================================
//===========================

function creerImage($idObjet, $hash)
{
  // rajoute une image à la fin (en mettant order = count)

  $ordre = count(getImagesByObjet($idObjet)) + 1;

  $SQL = "INSERT INTO Image(hash, idObjet, ordre)";
  $SQL .= " VALUES ('$hash','$idObjet','$ordre')";

  return SQLInsert($SQL);
}

function getImagesByObjet($idObjet)
{
  //Renvoie le tableau d'images (objets JSON)
  //relatif à l'objet d'id idObjet
  $SQL = "SELECT i.* FROM Image i";
  $SQL .= " INNER JOIN Objet o ON i.idObjet= o.id";
  $SQL .= " WHERE i.idObjet = '$idObjet'";
  $SQL .= " ORDER BY ordre";

  return parcoursRs(SQLSelect($SQL));
}

function supprimerImage($idImage)
{
  $SQL = "SELECT hash FROM Image WHERE id='$idImage'";

  $hash = SQLGetChamp($SQL);

  $SQL = "DELETE FROM Image WHERE id='$idImage'";
  SQLDelete($SQL);

  $SQL = "SELECT * FROM Image WHERE hash='$hash'";

  if (count(parcoursRs(SQLSelect($SQL))) == 0) { // C'était la dernière mention de l'image dans la BDD
    // On supprime le fichier
    $file = "uploads/imagesObjets/" . $hash . ".jpg";
    if (file_exists($file)) {
      unlink($file);
    }
  }
}

function choisirImage($idObjet, $idImage)
{
  //Retourne l'objet JSON représentant l'image donnée 
  // dont $idImage est en paramètres
  // associée à l'objet dont l'id est $idObjet
  $SQL = "SELECT i.* FROM Image i";
  $SQL .= " INNER JOIN Objet o ON i.idObjet= o.id";
  $SQL .= " WHERE i.idObjet = '$idObjet' AND i.id='$idImage'";

  return parcoursRs(SQLSelect($SQL));
}

// TODO: if image is not available, return hash for a placeholder image

function choisirImageByOrder($idObjet, $imageOrdre)
{
  //Retourne l'objet JSON représentant l'image donnée
  // dont $idImage est en paramètres
  // associée à l'objet dont l'id est $idObjet
  $SQL = "SELECT i.* FROM Image i";
  $SQL .= " INNER JOIN Objet o ON i.idObjet= o.id";
  $SQL .= " WHERE i.idObjet = '$idObjet' AND i.ordre='$imageOrdre'";

  return parcoursRs(SQLSelect($SQL));
}

function orderImages($idArray)
{
  $array = explode(",", $idArray);
  $x = 1;
  foreach ($array as $idImage) {
    if (!$idImage == "") {
      $SQL = "UPDATE Image SET
            ordre='$x'
            WHERE id=$idImage";

      SQLUpdate($SQL);
      ++$x;
    }
  }
}

//===========================
// Fonctions pour les objets ============================================
//===========================


//La fonction creerObjet permet de d'ajouter un objet dans la base de données en lui donnant ses infos 
//(sauf id et dateCreation qui sont généré  automatiquement pas la base de données. )
function creerObjet($nom, $idProprietaire, $description, $typeAnnonce, $statutObjet, $categorie)
{
  //Crée un objet dans la base de données
  //et retourne l'id de l'objet créé

  //Pour éviter les injestion de html il faut encoder les caractères spéciaux HTML :
  $nom = htmlspecialchars($nom);
  $description = htmlspecialchars($description);

  $SQL = "INSERT INTO Objet(nom, idProprietaire, description, typeAnnonce, statutObjet, categorieObjet)";
  $SQL .= " VALUES ('$nom','$idProprietaire','$description','$typeAnnonce','$statutObjet','$categorie')";

  return SQLInsert($SQL);
}

function creerObjetVide($idProprietaire)
{
  //Crée un objet vide dans la base de données
  //et retourne l'id de l'objet créé

  $SQL = "INSERT INTO `Objet` (`id`, `nom`, `idProprietaire`, `description`, `typeAnnonce`, `statutObjet`, `idCategorie`, `dateCreation`, `debutPret`, `finPret`)";
  $SQL .= " VALUES (NULL, NULL, '$idProprietaire', NULL, 'Don', 'Brouillon', NULL, CURRENT_TIMESTAMP, NULL, NULL)";

  return SQLInsert($SQL);
}

function objetBrouillon($idUser)
{
  $SQL = "SELECT id FROM Objet WHERE idProprietaire='$idUser' AND statutObjet='Brouillon'";
  return SQLGetChamp($SQL);
}

//   La fonction modifierObjet(idProprietaire) permet de modifier un objet dans la base de données
// tous les paramètres doivent être donnés : idObjet, nom, description, typeAnnonce, statutObjet et categorieObjet
//   elle ne modifie pas l'id de l'objet ni la date de création 
function modifierObjet($idObjet, $nom, $description, $idCategorie, $typeAnnonce, $statutObjet)
{
  $nom = htmlspecialchars($nom);
  $description = htmlspecialchars($description);

  $SQL = "UPDATE Objet SET
            nom='$nom',
            description='$description',
            typeAnnonce='$typeAnnonce',
            statutObjet='$statutObjet',
            idCategorie='$idCategorie'
          WHERE id='$idObjet'";

  SQLUpdate($SQL);
}

//   La fonction suprimerObjet(idObjet) permet de supprimer un objet de la base de données
// Elle renvoie false si ca na pas marché 
function supprimerObjet($idObjet)
{
  // On supprime d'abord toutes les images associées à cet objet
  $SQL = "SELECT id FROM Image WHERE idObjet='$idObjet'";
  $images = parcoursRs(SQLSelect($SQL));
  foreach ($images as $img) {
    supprimerImage($img['id']);
  }

  $SQL = "DELETE FROM Objet WHERE id='$idObjet'";

  SQLDelete($SQL);
}

//===========================
// Fonctions pour categorie ============================================
//===========================

function getCategorie($idCategorie)
{
  $SQL = "SELECT c.nom from Categorie c";
  $SQL .= " INNER JOIN Objet o on o.idCategorie = c.id";
  $SQL .= " WHERE o.idCategorie='$idCategorie'";
  return SQLGetChamp($SQL);
  //parcoursRs(SQLSelect($SQL));
}

//pour ajouter pour le modérateur
function ajouterCategorie($nom)
{
  $SQL = "INSERT INTO Categorie(nom)";
  $SQL .= " VALUES ('$nom')";
  return SQLInsert($SQL);
}
//pour supprimer pour le modérateur
function supprimerCategorie($idCategorie)
{
  $SQL = "DELETE FROM Categorie WHERE id='$idCategorie'";
  SQLDelete($SQL);
}

function getCategorieByNom($nomCategorie)
{
  $SQL = "SELECT * FROM Categorie WHERE nom ='$nomCategorie'";
  return parcoursRs(SQLSelect($SQL));
}

function suggestionsObjets($debutNom)
{
  $debutNom = htmlspecialchars($debutNom);
  $SQL = "SELECT id, nom FROM Objet WHERE nom LIKE '$debutNom%'";
  return parcoursRs(SQLSelect($SQL));
}
function getCategorieIdByNom($nomCategorie)
{
  $nomCategorie = htmlspecialchars($nomCategorie);
  $SQL = "SELECT id FROM Categorie WHERE nom = '$nomCategorie'";
  return SQLGetChamp($SQL); // renvoie directement l’id ou false
}

//   fonction ListerObjets(....) permet de lister les objets de la base de données
//   en fonction de plusieurs paramètres donné dans un tableau associatif $options: 
//   - categorie (string) : catégorie de l'objet
//   - type (string) : don ou emprunt
//   - utilisateur (int) : id du propriétaire de l'objet
//   - statut (tableau de string ou juste statut string) : satut de l'objet ex : ['disponible, 'donne'] ou juste 'donne'
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
function listerObjets($options = array())
{

  // la tableau associatif $options peut contenir : 
  // 'categorie', 'type', 'utilisateur', 'statut', 'amount', 'sort'
  $SQL = "SELECT * FROM Objet WHERE 1=1"; //toujours vrai, donc permet de tout selectionner

  // Filtrage par catégorie (par nom, via idCategorie)
  if (!empty($options['categorie']) && $options['categorie'] !== "all") {
    $categorie = htmlspecialchars($options['categorie']);
    // On récupère l'id de la catégorie à partir de son nom
    $SQLcat = "SELECT id FROM Categorie WHERE nom='$categorie'";
    $idCategorie = SQLGetChamp($SQLcat);
    if ($idCategorie) {
      $SQL .= " AND idCategorie='$idCategorie'";
    } else {
      // Si la catégorie n'existe pas, aucun résultat ne doit être retourné
      $SQL .= " AND 0";
    }
  }



  // Filtrage par type
  if (!empty($options['type']) && $options['type'] !== "all") {
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
    if (is_array($options['statut'])) {
      $statuts = array_map('htmlspecialchars', $options['statut']);
      $statuts = array_map(function ($s) {
        return "'$s'";
      }, $statuts);
      $SQL .= " AND statutObjet IN (" . implode(',', $statuts) . ")";
    } else {
      $statut = htmlspecialchars($options['statut']);
      $SQL .= " AND statutObjet='$statut'";
    }
  }

  // sécurisation : un utilisateur ne doit pas pouvoir accéder aux annonces archivés d'un autre utilisateur sauf si il est modérateur
  if (valider("connecte", "SESSION")) {
    $idCurrentUser = valider("idUser", "SESSION");
    if (!isModerateur($idCurrentUser)) {
      $SQL .= " AND ((statutObjet!='Archive' AND statutObjet!='Brouillon') OR idProprietaire=$idCurrentUser)"; // il doit être propriétaire pour voir une annonce archivée
    } // si modérateur, pas de restrictions
  } else {
    $SQL .= " AND statutObjet!='Archive' AND statutObjet!='Brouillon'"; // On n'affiche que les annonces non archivés
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

  //Le tableau renvoyé doit aussi contenir les images associées à chaque objet!!
  $res = parcoursRs(SQLSelect($SQL));


  // Pour chaque objet, on ajoute le champ "images"
  foreach ($res as &$objet) {
    $objet['images'] = getImagesByObjet($objet['id']);
    // Ajoute le nom de la catégorie à chaque objet
    if (isset($objet['idCategorie'])) {
      $objet['categorieNom'] = SQLGetChamp("SELECT nom FROM Categorie WHERE id='{$objet['idCategorie']}'");
    } else {
      $objet['categorieNom'] = '';
    }
  }
  unset($objet); // bonne pratique pour éviter les effets de bord

  return $res;
}



//La fonction infoObjet(idObjet) renvoie un tableau associatif contenant 
// les informations de l'objet d'ont l'id est passé en paramètre
function infoObjet($idObjet)
{
  $SQL = "SELECT * from Objet";
  $SQL .= " WHERE id='$idObjet'";
  return parcoursRs(SQLSelect($SQL));
}

<?php
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
<?php
include_once("libs/modele.php");

$catalogueUser = ListerObjetsASoi($userInfo[0]["id"]);



?>

<section class="profile-info-box" style="background-color: #fff; padding: 1.5em; border-radius: 8px;">
  <h2><?=$userString?></h2>

  <p><a href="<?= $userInfo[0]['facebook'] ?>">Facebook</a></p>
  <p><a href="mailto:<?= $userInfo[0]['mail'] ?>">Email : <?=$userInfo[0]["mail"]?></a></p>
  <p><?= $userInfo[0]["telephone"] ?></p>
</section>

<!-- ici même code que catalogue mais adapté-->

<fieldset id="annonces">
    <legend>Les annonces</legend>
</fieldset>


 <div>
    <!-- On affiche un message si aucune annonce n'est trouvée -->
        <h2 id="messageAucunObjet" style="display : none; color: red; text-align : center;">Aucune annonce trouvée...</h2>
    </div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const idUtilisateur = <?= json_encode($userInfo[0]["id"]) ?>;
    const objetsUtilisateur = <?= json_encode($catalogueUser) ?>;
    //Fonction pour créer une carte d'objet, qui sera ensuite ajoutée au catalogue
    // Cette fonction est appelée pour chaque objet reçu de la requête AJAX
    function mkCarteObjet(oObjet) {

        var carte = $('<div class="carteObjet"></div>');
        var lien = $('<a></a>').attr('href', 'annonce/' + oObjet.id);

        //Image, si il n'y a pas d'image, on met une image par défaut
        var imgSrc = (oObjet.images && oObjet.images.length > 0)
         ? 'uploads/imagesObjets/' + oObjet.images[0].hash +".jpg"
         : 'ressources/noImage.jpg';
        var img = $('<img>').attr('src', imgSrc).attr('alt', 'Photo de l’objet');

        var titreCarte = $('<h2></h2>').text(oObjet.nom);


        var details = $('<p></p>').html('<strong>Type :</strong> ' + oObjet.typeAnnonce + '<br>' +
            '<strong>Catégorie :</strong> ' + oObjet.categorieNom + '<br>' +
            '<strong>Statut :</strong> ' + oObjet.statutObjet);

        // Assembler la carte
        lien.append(img, titreCarte, details);
        carte.append(lien);

        return carte;

    }
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

     var idUser = idUtilisateur;
    $(document).ready(function() {

        if (objetsUtilisateur.length === 0) {
                $('#messageAucunObjet').show(); // Affiche le message "aucune annonce"
            } else {
                $.each(objetsUtilisateur, function(index, oObjet) {
                    const carte = mkCarteObjet(oObjet);
                    $('#annonces').append(carte);
                });
            }

    });//fin document ready


                /*
                var categorie = $('#categorieAnnonce').val();
                var type = $('#typeAnnonce').val();
                var sort = $('#sortAnnonce').val();
                 console.log(sort);*/



</script>

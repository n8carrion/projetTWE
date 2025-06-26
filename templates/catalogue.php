<!-- inclure la page modele.php -->
<?php
include_once("libs/modele.php");            
?>

<!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> -->
<script src ="js/jquery-3.7.1.min.js"></script>
<script src ="js/annonces.js"></script>






<!-- STRUCTURE DE LA PAGE ===================================== -->


<h1>Catalogue</h1>

<!-- Barre de filtres -->
<fieldset id="filtres">
    <legend>Filtres</legend>
    

        <label for="categorieAnnonce">Catégorie :</label>
        <select name="categorie" id="categorieAnnonce">
            <option value="all">Toutes les catégorie</option>
            <?php
            // On récupère les catégories d'objets depuis la base de données
            $SQL = "SELECT DISTINCT nom FROM Categorie";
            $categories = parcoursRs(SQLSelect($SQL));
            // On affiche chaque catégorie dans une option du select
            foreach ($categories as $categorie) {
                echo '<option value="' . htmlspecialchars($categorie['nom']) . '">' . htmlspecialchars($categorie['nom']) . '</option>';
            }
            ?>
        </select>

        <label for="typeAnnonce">Type :</label>
        <select name="type" id="typeAnnonce">
            <option value="all">Tous les types</option>
            <option value="don">Don</option>
            <option value="pret">Prêt</option>
        </select>

        <label for="sortAnnonce">Trier par :</label>
        <select name="sort" id="sortAnnonce">
            <option value="recent">Plus récentes d'abord</option>
            <option value="ancien">Plus anciennes d'abord</option>
        </select>

        <input type="text" id="recherche" name="recherche" placeholder="Rechercher...">
        <button id="btnFiltrer" type="button" >Filtrer</button>
    
</fieldset>



<!-- Catalogue des objets -->
<fieldset >
    <legend>Les annonces</legend>
    <div id="annonces">
        <!-- Les cartes d'objets seront ajoutées ici par la fonction chargerAnnonces() -->
    </div>
<!-- on fait une requête AJAX qui envoie les filtres à une page listerObjet.php -->
 <!-- si c'est un succes, alors ca nous renvoi comme réponse une tableau JSON clé = idObjet et valeur = objet JSON de l'objet -->
<!-- puis on parcours tout et on donne chaque objet sous format JSON à la fonction ajoutObjet(oObjet) -->
 <!-- Les carteObjet sont ajoutée avec requête AJAX -->

</fieldset>

 <div>
    <!-- On affiche un message si aucune annonce n'est trouvée -->
        <h2 id="messageAucunObjet" style="display : none; color: red; text-align : center;">Aucune annonce trouvée...</h2>
    </div>

<script>

    //Fonction pour créer une carte d'objet, qui sera ensuite ajoutée au catalogue 
    // Cette fonction est appelée pour chaque objet reçu de la requête AJAX
    // function mkCarteObjet(oObjet) {

    //     var carte = $('<div class="carteObjet"></div>');
    //     var lien = $('<a></a>').attr('href', 'annonce/' + oObjet.id);

    //     //Image, si il n'y a pas d'image, on met une image par défaut
    //     var imgSrc = (oObjet.images && oObjet.images.length > 0)
    //      ? 'uploads/imagesObjets/' + oObjet.images[0].hash +".jpg"
    //      : 'ressources/noImage.jpg';
    //     var img = $('<img>').attr('src', imgSrc).attr('alt', 'Photo de l’objet');

    //     var titreCarte = $('<h2></h2>').text(oObjet.nom);


    //     var details = $('<p></p>')
    //                 .append(
    //                     $('<div class="elemCarte"></div>')
    //                         .append('<div class="etiquette" >Type :</div>')
    //                         .append('<div>' + oObjet.typeAnnonce + '</div>')
    //                 )
    //                 .append(
    //                     $('<div class="elemCarte"></div>')
    //                         .append('<div class="etiquette">Catégorie :</div>')
    //                         .append('<div>' + oObjet.categorieNom + '</div>')
    //                 )
    //                 .append(
    //                     $('<div class="elemCarte"></div>')
    //                         .append('<div class="etiquette">Statut :</div>')
    //                         .append('<div>' + oObjet.statutObjet + '</div>')
    //                 );

    //     // Assembler la carte
    //     lien.append(img, titreCarte, details);
    //     carte.append(lien);

    //     return carte;

    // }
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


    $(document).ready(function() {

        // On charge TOUTES les annonces sans aucun filtre au chargement de la page
        // Requête AJAX pour charger toutes les annonces au chargement de la page
        chargerAnnonces();

       
        // Événement de clic sur le bouton Filtrer
        $('#btnFiltrer').click(function() {

            var params = {
            categorie: $('#categorieAnnonce').val(),
            type: $('#typeAnnonce').val(),
            sort: $('#sortAnnonce').val()
        };
        chargerAnnonces(params); 
            

        });//fin click sur le bouton Filtrer

    });//fin document ready


</script>



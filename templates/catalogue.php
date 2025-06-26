<!-- inclure la page modele.php -->
<?php
include_once("libs/modele.php");            
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


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
<fieldset id="annonces">
    <legend>Les annonces</legend>
   


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
            '<strong>Catégorie :</strong> ' + oObjet.categorieObjet + '<br>' +
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


    $(document).ready(function() {

        // On charge TOUTES les annonces sans aucun filtre au chargement de la page
        // Requête AJAX pour charger toutes les annonces au chargement de la page
        $.ajax({
            url: 'api/listerObjet', 
            type: 'GET',
            dataType : 'json',
            success: function(reponse) {
                console.log(reponse);  
                // Vider la liste des objets avant d'ajouter les nouveaux
                $('#annonces').empty();

                // Parcourir les annonces reçues et créer des cartes d'objet 
                // et l'ajouter à la liste des objets visibles dans le catalogue
                $.each(reponse, function(index, oObjet) {
                    // Créer une carte pour chaque objet
                    var carte = mkCarteObjet(oObjet);
                    // Ajouter la carte à la liste des objets
                    $('#annonces').append(carte);
                });
            }, 
            error: function(xhr, status, error) {
                console.error("Erreur lors de la récupération de tous les objets ", xhr.responseText, status, error);
            }
        });//fin requête AJAX affichage de toutes les annonces
       
        // Événement de clic sur le bouton Filtrer
        $('#btnFiltrer').click(function() {

            var categorie = $('#categorieAnnonce').val();
            var type = $('#typeAnnonce').val();
            var sort = $('#sortAnnonce').val(); 
             console.log(sort);

            $.ajax({
                url: 'api/listerObjet', 
                type: 'GET',
                dataType : 'json',
                data: {
                    "categorie": categorie,
                    "type": type,
                    "sort": sort
                },
                success: function(reponse) {
                    console.log(reponse); // Afficher la réponse dans la console pour le débogage
                    // Vider la liste des objets avant d'ajouter les nouveaux
                    $('#annonces').empty();

                    // Parcourir les annonces reçues et créer des cartes d'objet 
                    // et l'ajouter à la liste des objets visibles dans le catalogue
                    //la réponse est un tableau JSON d'objets
                    //pour chaque objet, on crée une carte et on l'ajoute à la liste des objets
                    $.each(reponse, function(index, oObjet) {
                        // Créer une carte pour chaque objet
                        var carte = mkCarteObjet(oObjet);
                        // Ajouter la carte à la liste des objets
                        $('#annonces').append(carte);
                    });
                    // Après avoir ajouté toutes les cartes
                    if ($('#annonces').children().length === 0) {
                        $('#messageAucunObjet').show();
                    } else {
                        $('#messageAucunObjet').hide();
                    }
                }, 
                error: function(xhr, status, error) {
    console.error("Erreur lors de la récupération des objets ", xhr.responseText, status, error);
}
            });//fin requête AJAX
        });//fin click sur le bouton Filtrer

    });//fin document ready


</script>



<script>

    //Fonction pour créer une carte d'objet, qui sera ensuite ajoutée au catalogue 
    // Cette fonction est appelée pour chaque objet reçu de la requête AJAX
    function mkCarteObjet(oObjet) {

        var carte = $('<div class="carteObjet"></div>');
        var lien = $('<a></a>').attr('href', 'annonce/' + oObjet.id);

        //Image, si il n'y a pas d'image, on met une image par défaut
        var imgSrc = (oObjet.images && oObjet.images.length > 0)
         ? 'uploads/imagesObjets/' + oObjet.images[0].hash
         : 'uploads/imagesObjets/default.jpg';
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

        // TODO : Charger toutes les annonces sans aucun filtre au chargement de la page
       
        // Événement de clic sur le bouton Filtrer
        $('#btnFiltrer').click(function() {

            var categorie = $('#categorie').val();
            var type = $('#typeAnnonce').val();
            $.ajax({
                url: 'listerObjets.php',
                type: 'GET',
                data: {
                    "categorie": categorie,
                    "type": type
                },
                success: function(reponse) {
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
                }
            });
        });//fin click sur le bouton Filtrer

    });//fin document ready


</script>

<style>
    /* style pour les cartes objet */
    .carteObjet {
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 10px;
        margin: 10px;
        display: inline-block;
        
    }
    .carteObjet img {
        width: 400px;
        height: auto;
        border-radius: 4px;
    }
</style>

<!-- STRUCTURE DE LA PAGE ===================================== -->


<h1>Catalogue</h1>

<!-- Barre de filtres -->
<fieldset id="filtres">
    <legend>Filtres</legend>
    

        <label for="categorie">Catégorie :</label>
        <select name="categorie" id="categorie">
            <option value="Vêtement">Vêtement</option>
            <option value="Informatique">Informatique</option>
            <option value="Nourriture">Nourriture</option>
            <option value="Divertissement">Divertissement</option>
            <option value="Service">Service</option>
        </select>

        <label for="type">Type :</label>
        <select name="type" id="typeAnnonce">
            <option value="">Tous les types</option>
            <option value="don">Don</option>
            <option value="pret">Prêt</option>
        </select>

        <input type="text" id="recherche" name="recherche" placeholder="Rechercher...">
        <button id="btnFiltrer" type="button" >Filtrer</button>
    
</fieldset>



<!-- Catalogue des objets -->
<fieldset id="annonces">
    <legend>Les annonces</legend>

    <!-- Chaque objet est représenté par une "carte" -->
    <div class="carteObjet">
        <!-- Si on clique sur  -->
        <a href="annonce/1"> <!-- annonce/idObjet -->
            <img src="uploads/imagesObjets/2_1.jpg" alt="Photo de l’objet">
            <h2>Table basse test</h2>
            <p><strong>Type :</strong>Don</p>
            <p><strong>Catégorie :</strong> Électroménager</p>
            <p><strong>Statut :</strong> Disponible</p>
        </a>
    </div>

    <div class="carteObjet">
        <!-- Si on clique sur  -->
        <a href="annonce/1"> <!-- annonce/idObjet -->
            <img src="uploads/imagesObjets/2_1.jpg" alt="Photo de l’objet">
            <h2>Table basse test</h2>
            <p><strong>Type :</strong>Don</p>
            <p><strong>Catégorie :</strong> Électroménager</p>
            <p><strong>Statut :</strong> Disponible</p>
        </a>
    </div>

    <div class="carteObjet">
        <!-- Si on clique sur  -->
        <a href="annonce/1"> <!-- annonce/idObjet -->
            <img src="uploads/imagesObjets/2_1.jpg" alt="Photo de l’objet">
            <h2>Table basse test</h2>
            <p><strong>Type :</strong>Don</p>
            <p><strong>Catégorie :</strong> Électroménager</p>
            <p><strong>Statut :</strong> Disponible</p>
        </a>
    </div>

    <div class="carteObjet">
        <!-- Si on clique sur  -->
        <a href="annonce/1"> <!-- annonce/idObjet -->
            <img src="uploads/imagesObjets/2_1.jpg" alt="Photo de l’objet">
            <h2>Table basse test</h2>
            <p><strong>Type :</strong>Don</p>
            <p><strong>Catégorie :</strong> Électroménager</p>
            <p><strong>Statut :</strong> Disponible</p>
        </a>
    </div>

    <div class="carteObjet">
        <!-- Si on clique sur  -->
        <a href="annonce/1"> <!-- annonce/idObjet -->
            <img src="uploads/imagesObjets/2_1.jpg" alt="Photo de l’objet">
            <h2>Table basse test</h2>
            <p><strong>Type :</strong>Don</p>
            <p><strong>Catégorie :</strong> Électroménager</p>
            <p><strong>Statut :</strong> Disponible</p>
        </a>
    </div>

    <div class="carteObjet">
        <!-- Si on clique sur  -->
        <a href="annonce/1"> <!-- annonce/idObjet -->
            <img src="uploads/imagesObjets/2_1.jpg" alt="Photo de l’objet">
            <h2>Table basse test</h2>
            <p><strong>Type :</strong>Don</p>
            <p><strong>Catégorie :</strong> Électroménager</p>
            <p><strong>Statut :</strong> Disponible</p>
        </a>
    </div>

    <div class="carteObjet">
        <!-- Si on clique sur  -->
        <a href="annonce/1"> <!-- annonce/idObjet -->
            <img src="uploads/imagesObjets/2_1.jpg" alt="Photo de l’objet">
            <h2>Table basse test</h2>
            <p><strong>Type :</strong>Don</p>
            <p><strong>Catégorie :</strong> Électroménager</p>
            <p><strong>Statut :</strong> Disponible</p>
        </a>
    </div>

    

     

    <!-- Répété avec requête AJAX -->

<!-- on fait une requête AJAX qui envoie les filtres à une page listerObjet.php -->
 <!-- si c'est un succes, alors ca nous renvoi comme réponse une tableau JSON clé = idObjet et valeur = objet JSON de l'objet -->
<!-- puis on parcours tout et on donne chaque objet sous format JSON à la fonction ajoutObjet(oObjet) -->

</fieldset>



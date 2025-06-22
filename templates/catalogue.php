<?php
include_once '../templates/header.php';
?>


<head>

    <style>
        fieldset {
            border: 2px solid #ccc;
        }

        legend {
            font-size: 1.5em;
        }

        .carte-objet {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #f9f9f9;
        }

        .carte-objet img {
            height: 200px;
        }

        .carte-objet h2 {
            margin-top: 0;
        }

        .carte-objet a {
            display: inline-block;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }
    </style>


    <script>
        //fonction pour créer une carte d'objet, elle sera ensuite apellée par la fonction chargerAnnonces
        function creerCarteObjet(id, titre, type, categorie, statut, image) {
            
            var carte = $('<div class="carteObjet"></div>');
            var lien = $('<a></a>').attr('href', 'index.php?view=ficheObjet&id=' + id);
            var img = $('<img>').attr('src', '../uploads/imagesObjets/' + image).attr('alt', 'Photo de l’objet');
            var titreCarte = $('<h2></h2>').text(titre);

            
            var details = $('<p></p>').html('<strong>Type :</strong> ' + type + '<br>' +
                                             '<strong>Catégorie :</strong> ' + categorie + '<br>' +
                                             '<strong>Statut :</strong> ' + statut);

            // Assembler la carte
            lien.append(img, titreElement, details);
            carte.append(lien);

            return carte;

        }
           

        // Fonction pour charger les annonces correspondantes à la catégorie et au type sélectionnés
        // et les afficher dans la liste des objets
        // Cette fonction est appelée lors du chargement de la page avec aucun filtre
        //  et lors du clic sur le bouton Filtrer
        function chargerAnnonces(categorie, type) {
            $.ajax({
                url: '.listerObjets.php',
                type: 'GET',
                data: {
                    "categorie": categorie,
                    "type": type
                },
                success: function(reponse) {
                    // Vider la liste des objets avant d'ajouter les nouveaux
                    $('#listeObjet').empty();

                    // Parcourir les annonces reçues et créer des cartes d'objet 
                    // et l'ajouter à la liste des objets visibles dans le catalogue
                    response.forEach(function(objet) {
                        var carte = creerCarteObjet(
                            objet.id,
                            objet.titre,
                            objet.type,
                            objet.categorie,
                            objet.statut,
                            objet.image
                        );
                        // Ajouter la carte à la liste des objets
                        $('#listeObjet').append(carte);
                    });
                }
                            

        });
    }
            

        $(document).ready(function() {
            

            // Charger toutes les annonces sans filtre au chargement de la page
            chargerAnnonces('', ''); // faire en sorte que la fonction chargerAnnonces soit appelée avec des paramètres vides pour charger toutes les annonces

            // Événement de clic sur le bouton Filtrer
            $('#btnFiltrer').click(function(e) {
                
                var categorie = $('#categorie').val();
                var type = $('#typeAnnonce').val();
                chargerAnnonces(categorie, type);
            });
        });
        


    </script>

</head>


<body>

<h1>Catalogue</h1>

<!-- Barre de filtres -->

<fieldset id="filtres">
    <legend>Filtres</legend>
        <form id="filtres">
            <label for="categorie">Catégorie :</label>
            <select name="categorie" id="categorie">
                <option value="meuble">Meuble</option>
                <option value="electromenager">Électromenager</option>
                <option value="vetement">Vetement</option>
                <option value="autre">Autre</option>
            </select>

            <label for="categorie">Catégorie :</label>
            <select name="type" id="typeAnnonce">
                <option value="">Tous les types</option>
                <option value="don">Don</option>
                <option value="pret">Prêt</option>
            </select>

            <input type="text" id="recherche" name="recherche" placeholder="Rechercher...">
            <button type="submit">Filtrer</button>
        </form>
</fieldset>


    
  <!-- Catalogue des objets -->
<fieldset id="annonces">
    <legend>Les annonces</legend>

    <!-- Chaque objet est représenté par une "carte" -->
    <div class="carte-objet">
        <!-- Si on clique sur  -->
      <a href="index.php?view=ficheObjet&id=1">
        <img src="../uploads/imagesObjets/2_1.jpg" alt="Photo de l’objet">
        <h2>Table basse test</h2>
        <p><strong>Type :</strong>Don</p>
        <p><strong>Catégorie :</strong> Électroménager</p>
        <p><strong>Statut :</strong> Disponible</p>
      </a>     
    </div>

     <!-- Répété avec requête AJAX -->
</fieldset>



   




  
</body>
</html>

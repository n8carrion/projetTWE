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
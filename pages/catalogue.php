<?php
include_once '../pages/header.php';
?>


<head>

    <style>
        fieldset {
            border: 2px solid #ccc;
        }

        legend {
            font-size: 1.5em;
        }

        .carteObjet {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #f9f9f9;
        }

        .carteObjet img {
            height: 200px;
        }


        .carte-objet a {
            display: inline-block;
            margin-top: 10px;
            color:rgb(0, 0, 0); 
            text-decoration: none;
        }
    </style>
    <script src="../libs/utils.js"></script>
    <script src="../libs/ajax.js"></script>

    <script>

        
     function integrer(reponse) {
            console.log("Reçu :", reponse);

            // 1. On parse la chaîne JSON en un objet JS
            const data = JSON.parse(reponse);
            console.log("Objet JSON :", data);

            // 2. On vide la liste actuelle
            const ul = document.getElementById("listeObjet");
            ul.innerHTML = "";

            // 3. Vérification qu’il y a des objets
            if (data.listeObjets && data.listeObjets.length > 0) {
                data.listeObjets.forEach((objet, i) => {
                    const li = document.createElement("li");
                    li.className = "carteObjet"; // Pour styliser comme tes cartes
                    li.id = `objet_${i}`;

                    //
                    li.innerHTML = `
                        <a href="index.php?view=ficheObjet&id=${objet.id}">
                            <h2>${objet.nom}</h2>
                            <p><strong>Type :</strong> ${objet.typeAnnonce}</p>
                            <p><strong>Catégorie :</strong> ${objet.categorieObjet}</p>
                            <p><strong>Statut :</strong> ${objet.statutObjet}</p>
                        </a>
                    `;

                    ul.appendChild(li);
                });
            } else {
                // Si aucun objet trouvé
                ul.innerHTML = "<li>Aucun objet trouvé.</li>";
            }
    }



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

    <!-- c'est une liste d'annonces -->

    <ul  id="listeObjet">
            <!-- c'est ici que vont être ajouter les annonces recues par la requête AJAX -->
            <!-- Chaque objet est représenté par un div de classe carteObjet -->
             <li> 
                <!-- ce premier element de liste est un test -->
                <!-- d'autre element seront ajoutés grace à la réponse recue par la requête ajax -->
                <div class="carteObjet">
                    <a href="index.php?view=ficheObjet&id=1">
                        <img src="../uploads/imagesObjets/2_1.jpg" alt="Photo de l’objet">
                        <h2>Table basse test</h2>
                        <p><strong>Type :</strong>Don</p>
                        <p><strong>Catégorie :</strong> Électroménager</p>
                        <p><strong>Statut :</strong> Disponible</p>
                    </a>     
                </div>


            </li>
    </ul>

    
    

    
</fieldset>



   




  
</body>
</html>
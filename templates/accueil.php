<script>
    //rajouter le chargment des annonces
</script>

<div id=description>
<h1>La REZerve</h1>
<!-- <img class = "logo" src="ressources/logoLaREZerve1.png"> -->
<p>
Ici, on donne une seconde vie aux objets sur la résidence de Centrale ! <br>

Vous avez un grille-pain qui traîne ? Besoin d’une casserole ou d’un vidéoprojecteur pour le week-end ?
Sur la REZerve vous pouvez donner ou emprunter facilement des objets entre résident·e·s et assos de Centrale Lille Institut. <br>

Moins d’achats neufs, plus de seconde main, plus de partage.
En participant, vous contribuez concrètement à une consommation plus responsable en phase avec les Objectifs de Développement Durable. <br>

Explorez le catalogue ou proposez vos objets dès maintenant !
</p>

</div>

<fieldset id="annonces">
    <legend>Les dernières annonces</legend>
    <div class="carteObjet">
        <!-- Si on clique sur  -->
        <a href="annonce/1"> <!-- annonce/idObjet -->
            <img src="uploads/imagesObjets/dWc3XpV9MqL7zRy.jpg" alt="Photo de l’objet">
            <h2>Commode test</h2>
            <p><strong>Type :</strong>Don</p>
            <p><strong>Catégorie :</strong> Électroménager</p>
            <p><strong>Statut :</strong> Disponible</p>
        </a>
    </div>

    <div class="carteObjet">
        <!-- Si on clique sur  -->
        <a href="annonce/1"> <!-- annonce/idObjet -->
            <img src="uploads/imagesObjets/Yc3qNzX84JrKbvF.jpg" alt="Photo de l’objet">
            <h2>Table basse test</h2>
            <p><strong>Type :</strong>Don</p>
            <p><strong>Catégorie :</strong> Électroménager</p>
            <p><strong>Statut :</strong> Disponible</p>
        </a>
    </div>

    <div class="carteObjet">
        <!-- Si on clique sur  -->
        <a href="annonce/1"> <!-- annonce/idObjet -->
            <img src="uploads/imagesObjets/PqKmZRY29xTW48j.jpg" alt="Photo de l’objet">
            <h2>Four test</h2>
            <p><strong>Type :</strong>Don</p>
            <p><strong>Catégorie :</strong> Électroménager</p>
            <p><strong>Statut :</strong> Disponible</p>
        </a>
    </div>
   


<!-- on fait une requête AJAX qui envoie les filtres à une page listerObjet.php -->
 <!-- si c'est un succes, alors ca nous renvoi comme réponse une tableau JSON clé = idObjet et valeur = objet JSON de l'objet -->
<!-- puis on parcours tout et on donne chaque objet sous format JSON à la fonction ajoutObjet(oObjet) -->
 <!-- Les carteObjet sont ajoutée avec requête AJAX -->

</fieldset>
    <!-- Chaque objet est représenté par une "carte" -->










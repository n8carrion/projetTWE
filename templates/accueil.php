<script src ="js/jquery-3.7.1.min.js"></script>
<script src ="js/annonces.js"></script>

<script>
    var params = {
            amount : 4,// Nombre d'annonces à afficher
            sort: "recent" // Tri par date de création
    };
    // Appel de la fonction pour charger les annonces
    //  voulues dans l'id "annonces"
    chargerAnnonces(params); 
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

<fieldset>
    <legend>Les dernières annonces</legend>
    <div id="annonces">
        <!-- Les cartes seront ajoutées ici grace à chargerAnnonces -->
    </div>
</fieldset>











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


<div id="description" style="display: flex; align-items: center; justify-content: space-between;border-radius : 3px;  margin : 10px;">
    <div id="texteAccueil" style="flex: 2;">
        <h1>La REZerve</h1>
        <p>
            Ici, on donne une seconde vie aux objets sur la résidence de Centrale ! </br></br>
            Vous avez un grille-pain qui traîne ? Besoin d’une casserole ou d’un vidéoprojecteur pour le week-end ?<br>
            Sur la REZerve vous pouvez donner ou emprunter facilement des objets entre résident·e·s et assos de Centrale Lille Institut. <br>
            Moins d’achats neufs, plus de seconde main, plus de partage.</br></br>
            En participant, vous contribuez concrètement à une consommation plus responsable en phase avec les Objectifs de Développement Durable. <br>
            Explorez le catalogue ou proposez vos objets dès maintenant !
        </p>
    </div>
    <div id="imgAccueil" style="flex: 1; display: flex; justify-content: flex-end;">
        <a href ="https://www.residence-vinci.fr/" target = "_blank">
            <img  id="imgResidence" src="ressources/photoResidence.jpg" alt="Photo de la résidence (REZ)" style="max-width: 450px; margin:8px;  width: 100%; margin-right : 10px; height: auto; border-radius: 3px;">
        </a>
    </div>
</div>


</div>

<fieldset id="stickyAnnonces">
    <legend>Les dernières annonces</legend>
    <div id="annonces">
        <!-- Les cartes seront ajoutées ici grace à chargerAnnonces -->
    </div>
</fieldset>











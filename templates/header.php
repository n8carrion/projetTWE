<!-- Style pour le header et le footer -->
<style>

    /* STYLE POUR LES BOUTONS de classe "btn" */
    .btn {
        display: inline-block;
    padding: 8px 15px;
    background-color:rgb(170, 202, 41);
    color: rgba(251,249,246,255);
    /* enleve le texte souligné pour un lien */
    text-decoration: none; 
    border-radius: 3px;
    font-weight: bold;
    }
    .btn:hover {
        background-color: rgb(150, 180, 30); /* Couleur au survol */
    }

    /* STYLE POUR LE MENU DE NAVIGATION de classe "menu" */
    .menu  a {
    text-decoration: none; 
    padding: 8px 15px;
    color: white;
    background-color:rgb(21, 60, 9); 
    font-weight: bold;
    border-radius: 3px;
    
    }

    .menu a:hover {
    background-color:rgb(71, 121, 33);
    color: white;
    }


    /* STYLE POUR LES BANNIERE (header et footer), de classe "banniere" */
    .banniere {
        background-color:rgba(251,249,246,255); /* Couleur de fond */
        padding: 10px;
        border : 1px solid black;
        border-radius: 3px;
    
    }

    .banniere a{
        text-decoration: none; 
    }


    #logo  {
        width: 200px; 
    }


    #Odd img {
        width: 70px; /* Largeur des images ODD */
        height: 70px; /* Hauteur des images ODD */
    }

     #odd11:hover, #odd12:hover {
        opacity : 70% ; 
    }



</style>


<div id="header" class="banniere">

    
        <a href="accueil">
            <img id="logo" src="ressources/logoLaREZerve1.png" />
        </a>
    <div class="menu" style="display : inline">
        <a id="lienAcceuil" href="accueil">Accueil</a>
        <a id="lienCatalogue" href="catalogue">Catalogue</a>
    </div>



    
        <input id=barreSearch type="search" placeholder="Recherche d'une annonce">
        <a class="btn" href="editionObjet">+ Ajouter une annonce</a>

        <!-- TODO Le lien se connecter ne doit apparaitre que si on es connecté -->
        
    <div class="menu" style="display : inline">
        <a id="lienSeConnecter" href="login">Se connecter</a>
    </div>
    
</div>
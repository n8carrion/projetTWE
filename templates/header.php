
<style>
    #banniere {
        background-color:rgb(240, 240, 240);
        border : 1px solid black;
        padding: 10px;
        position : relative;
    }
    #logo img {
        width: 250px;
        display:inline ;
    }
    #titre {
        font-size: 24px;
        margin: 10px 0;
    }

    a {
        margin: 5px;
        text-decoration: none;
        text-style : bold;
    }
    #banniere div {
        display:inline ;
    }
    #barreSearch {
        position:absolute ;
        right: 300px;
    }
    #lienConnexion {
        position:absolute;
        right:10px;
    }
    #BtnAdd{
        display:none ;
        right: 100px ;
        position:absolute ;
    }

</style>


<body>

   

    <div id="banniere">

        <!-- <h1 id="titre"> La REZerve </h1> -->
        <!-- le logo est cliquable et contient un lien vers l'acceuil -->
        <div id="logo">
            <a href="accueil"><img src="ressources/logoLaREZerve1.png" alt="Logo de la REZerve"></a>
        </div>
        <div id="menu">
            <a id ="lienAcceuil" href="accueil">Accueil</a>
            <a id ="lienCatalogue" href="catalogue">Catalogue</a>
        </div>

        <input id=barreSearch type="search" placeholder="Recherche d'une annonce">
        <input id=BtnAdd type="button" value="+Ajouter une annonce">
        <a id ="lienConnexion" href="login">Se connecter</a>
    

        <?php
        // Si l'utilisateur n'est pas connecte, on affiche un lien de connexion 
        // if (!valider("connecte","SESSION"))
        // 	echo "<a id=\"lienConnexion\" href=\"index.php?view=login\">Se connecter</a>";
        ?>

</div>

</body>

<style>
    #banniere {
        background-color:beige;
        padding: 20px;
        position : relative;
    }
    #logo img {
        width: 100px;
    }
    #titre {
        font-size: 24px;
        margin: 10px 0;
    
    }

    #menu {
        
    }
    a {
        margin: 5px;
        text-decoration: none;
        text-style : bold;
    }

</style>


<body>

    <div id="banniere">

    

        <h1 id="titre"> La REZerve </h1>
        <!-- le titre est cliquable et contient un lien vers l'acceuil -->
        <div id="logo">
            <a href="index.php?view=accueil"><img src="../ressources/logoLaREZerve1.png" alt="Logo de la REZerve"></a>

        <div id="menu">
            <a id ="lienAcceuil" href="index.php?view=accueil">Accueil</a>
            <a id ="lienCatalogue" href="index.php?view=catalogue">Catalogue</a>
        </div>

        

        <?php
        // Si l'utilisateur n'est pas connecte, on affiche un lien de connexion 
        // if (!valider("connecte","SESSION"))
        // 	echo "<a href=\"index.php?view=login\">Se connecter</a>";
        ?>


    </div>

</body>
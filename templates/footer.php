<style>
#banniere {
        background-color:rgb(240, 240, 240);
        border : 1px solid black;
        padding: 10px;
        margin:5px;
        position : relative;
        height: 15%;
    }
#banniere div {
    display:inline;
}
#logo img {
    width: 200px;
    position:absolute ;
    left:2%;

}
#menu a {
    margin:5px;
    position:absolute;
    top:25%;
}

#lienAcceuil {
    left:20% ;
}
#lienCatalogue {
    left:25% ;
}
#lienAPropos {
    left:31% ;
}

#Odd img {
    width: 10%;
    height: 80%;
    display:inline ;
    position: absolute ;
    bottom:10%;
}
#footext {
    position:absolute ;
    top:4%;
    left:50%;
    right:25% ;
    text-align:justify ;
    /*font-weight:bolder;*/
}
#odd11 {
    right: 13%;
    
}
#odd12 {
    right: 1%;
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
            <a id ="lienAcceuil" href="accueil">Accueil </a> 
            <a id ="lienCatalogue" href="catalogue">Catalogue </a> 
            <a id = "lienAPropos" href="apropos">A Propos</a> 
        </div>
        <div>
            <p id=footext>
            
                La REZerve répond aux objectifs de 
                développement durable (ODD) suivants: <br>
                11. Villes et Communautés durables <br>
                12. Consommation et production responsable
            </p>
        </div>
        <div id="Odd">
            <a target="_blank" href="https://pactemondial.org/17-objectifs-developpement-durable/odd-11-villes-et-communautes-durables/">
                <img id="odd11" src="ressources/ODD11.png" alt="ODD 11: Villes et Communautés durables">
            </a>
            <a target="_blank" href="https://pactemondial.org/17-objectifs-developpement-durable/odd-12-consommation-et-production-responsable/#:~:text=L'ODD%2012%20encourage%20sp%C3%A9cifiquement,produits%20nuisibles%20pour%20l'environnement.">
             <img id="odd12" src="ressources/ODD12.png" alt="ODD12: Consommation et production ">
            </a>
        </div>
    

        <?php
        // Si l'utilisateur n'est pas connecte, on affiche un lien de connexion 
        // if (!valider("connecte","SESSION"))
        // 	echo "<a id=\"lienConnexion\" href=\"index.php?view=login\">Se connecter</a>";
        ?>

</div>

</body>
<?php
include_once("libs/maLibUtils.php");
?>
<script src ="js/jquery-3.7.1.min.js"></script>
<!-- inclure la librairie jQuery -->

<style>
#header {
    position: sticky;
    top: 0;
    z-index: 1000;}
</style>

<div id="header" class="banniere">

    
        <a href="accueil">
            <img class="logo" src="ressources/logoLaREZerve1.png" />
        </a>
    <div class="menu" style="display : inline">
        <a id="lienAcceuil" href="accueil">Accueil</a>
        <a id="lienCatalogue" href="catalogue">Catalogue</a>
        <a class="btn" id="btnAjouterNot" href="annonce/edit">+ Ajouter une annonce</a>
    </div>
        <!-- <input id=barreSearch type="search" placeholder="Recherche d'une annonce"> -->
        
    <div class="menu" style="display : inline">
<?php
if (valider("connecte","SESSION")) {
    $userInfo = infoUtilisateur(valider("idUser","SESSION"));
    $userString = $userInfo[0]["prenom"] . " " . $userInfo[0]["nom"];
    
    echo '<a class="btn" href="annonce/edit">+ Ajouter une annonce</a> ';
    echo '<a id="lienSeConnecter" href="profil">Mon profil</a> ';
    echo '<a id="lienSeConnecter" href="logout">Se déconnecter</a> ';
    echo '<h2>Bienvenue '. $userString .' !</h2>';
} else {
    echo '<a id="lienSeConnecter" href="login">Se connecter</a> ';
}
?>
    </div>
    
    
</div>


<script>
    $(document).ready(function() {
        $("#btnAjouterNot").click(function() {
            alert("Pour ajouter une annonce, tu dois être connecté !");
        });

        

    });//fin document ready
</script>
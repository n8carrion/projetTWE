<?php
include_once("libs/maLibUtils.php");
?>

<div id="header" class="banniere">

    
        <a href="accueil">
            <img class="logo" src="ressources/logoLaREZerve1.png" />
        </a>
    <div class="menu" style="display : inline">
        <a id="lienAcceuil" href="accueil">Accueil</a>
        <a id="lienCatalogue" href="catalogue">Catalogue</a>
    </div>
        <input id=barreSearch type="search" placeholder="Recherche d'une annonce">
        
    <div class="menu" style="display : inline">
<?php
if (valider("connecte","SESSION")) {
    $userInfo = infoUtilisateur(valider("idUser","SESSION"));
    $userString = $userInfo[0]["prenom"] . " " . $userInfo[0]["nom"];
    echo 'Bienvenue '. $userString .' !';
    echo '<a class="btn" href="annonce/edit">+ Ajouter une annonce</a>';
    echo '<a id="lienSeConnecter" href="profil">Mon profil</a>';
    echo '<a id="lienSeConnecter" href="logout">Se déconnecter</a>';
} else {
    echo '<a id="lienSeConnecter" href="login">Se connecter</a>';
}
?>
    </div>
    
</div>
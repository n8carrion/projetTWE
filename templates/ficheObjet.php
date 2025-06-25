<?php
    include_once "libs/modele.php";
    $infoObjet = infoObjet($idObjet)[0];
    $nom = $infoObjet["nom"];
    $idUser = $infoObjet["idProprietaire"];
    $infoUser =infoUtilisateur($idUser)[0];
    $nomUser = $infoUser["nom"];
    $prenomUser = $infoUser["prenom"];
    $userMail = $infoUser["mail"];
    $userTelephone = $infoUser["telephone"];


    // TODO :
    // - LINK IMAGES TO FICHE OBJET
    //- add dates pret (for the moment null)
    // - link to user profil
    // - link to 404 if id doesnt exist
?>
<div class="container">
    <div class="left">
        <div class="main-image">
            <img src="uploads/imagesObjets/1_1.jpg" alt="Image principale" class="main-img">
        </div>
        <div class="thumbnails">
            <div></div>
            <div></div>
            <div></div> <!-- this here can be changed to img, then in <style> would be .thumbnails img-->
        </div>
    </div>

    <div class="details">
        <h2 id="objet-nom"><?= $nom ?></h2>
        <p id="statutObjet"><?=$infoObjet["statutObjet"]?> </p>

        <p><strong>Description :</strong></p>
        <p id="objet-description"> <?=$infoObjet['description'] ?></p>

        <p id="categorieObjet"><strong>Catégorie :</strong> Meuble TODO : get categorie from idCategorie</p>
        <p id=objet-typeAnnonce><strong>Type :</strong> <?=$infoObjet["typeAnnonce"]?></p>

        <p>
            <strong>Publié par :</strong><?=$prenomUser  ?> <?=$nomUser ?>
            <button id="button_user_profil">
                <a href="profil/1">Voir Profil</a></button>
        </p>

        <p id="objet-dates"><strong>Dates de prêt :</strong> du 01/07/2025 au 15/07/2025</p>

        <div class="contact">
            <p id="user-mail"><strong>Contact : </strong> <?= $userMail ?></p>
            <p id="user-telephone"><strong>Telephone : </strong><?=$userTelephone?></p>
            <p id="user-adresse"><strong>Adresse : </strong><?=$infoUser["adresse"]?></p>
        </div>

        <div class="admin-options">
            <button> <!-- not sure yet if the link will be js or done just with <a></a>-->
                <a href="annonce/1/edit">
                    Modifier l'annonce </a>
            </button>

            <button>Supprimer l'annonce</button>
        </div>
    </div>
</div>

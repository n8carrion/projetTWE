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

    $image1 = choisirImageByOrder($idObjet, 1) ;
    $image2 = choisirImageByOrder($idObjet, 2) ;
    $image3 = choisirImageByOrder($idObjet, 3) ;
    $image4 = choisirImageByOrder($idObjet, 4) ;
    $mainImage = $image1[0]["hash"];
    $source1 = "uploads/imagesObjets/" . $mainImage  . ".jpg";
    $source2 = "uploads/imagesObjets/" . $image2[0]["hash"]  . ".jpg";
    $source3 = "uploads/imagesObjets/" . $image3[0]["hash"]  . ".jpg";
    //$source4 = "uploads/imagesObjets/" . $image4[0]["hash"]  . ".jpg";


    // TODO :
    //
    //- add dates pret (for the moment null)
    // - link to user profil
    // - link to 404 if id doesnt exist
    // - add placeholder image if image not available
?>
<div class="container">
    <div class="left">

            <img class="main-image" src="<?=$source1 ?> "alt="Image principale" >

        <div class="thumbnails">
            <img src="<?=$source2 ?>" alt="thumbnail" >
            <img src="<?=$source3 ?>"alt="thumbnail" >
            <img src="<?=$source3 ?>" alt="thumbnail" ><!-- this here can be changed to img, then in <style> would be .thumbnails img-->
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
                <a href="profil">Voir Profil</a></button>
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

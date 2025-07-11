<script src="js/jquery-3.7.1.min.js"></script>

<?php
    include_once "libs/modele.php";
    $infoObjet = infoObjet($idObjet)[0];
    $idcategorie = $infoObjet["idCategorie"];
    $cat = getCategorie($idcategorie);
    $nom = $infoObjet["nom"];
    $idUser = $infoObjet["idProprietaire"];
    $infoUser =infoUtilisateur($idUser)[0];
    $nomUser = $infoUser["nom"];
    $prenomUser = $infoUser["prenom"];
    $userMail = $infoUser["mail"];
    $userTelephone = $infoUser["telephone"];
    $images = getImagesByObjet($idObjet);
    $size = count($images);

?>
<div class="container">
    <div class="left">
          
          <?php if (empty($images)): ?>
          <div class="mySlides">
            <div class="numbertext">1 / 1</div>
            <img src="ressources/noImage.jpg" alt="Aucune image" style="width:100%">
          </div>
            <?php else: ?>
              <?php foreach ($images as $index => $image): ?>
                <div class="mySlides">
                  <div class="numbertext"><?= ($index + 1) . " / " . $size ?></div>
                  <img src="<?= "uploads/imagesObjets/" . $image["hash"] . ".jpg" ?>" style="width:100%">
                </div>
              <?php endforeach; ?>
              <?php if (!empty($images)): ?>
              <a class="prev" onclick="plusSlides(-1)">❮</a>
              <a class="next" onclick="plusSlides(1)">❯</a>

              <div class="row">
                <?php foreach ($images as $index => $image): ?>
                  <div class="column">
                    <img class="demo cursor" src="<?= "uploads/imagesObjets/" . $image["hash"] . ".jpg" ?>"
                         style="width:100%" onclick="currentSlide(<?= $index + 1 ?>)" alt="Slide <?= $index + 1 ?>">
                  </div>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
            <?php endif; ?>
    </div>

    <div class="details">
        <h2 id="objet-nom"><?= $nom ?></h2>
        <p><strong>Statut :</strong></p>
        <p id="statutObjet"><?=$infoObjet["statutObjet"]?> </p>

        <p><strong>Description :</strong></p>
        <p id="objet-description"> <?=$infoObjet['description'] ?></p>

        <p id="categorieObjet"><strong>Catégorie :</strong> <?= $cat?></p>
        <p id=objet-typeAnnonce><strong>Type :</strong> <?=$infoObjet["typeAnnonce"]?></p>

        <p>
            <strong>Publié par :</strong><?=$prenomUser  ?> <?=$nomUser ?>
            <button class="btn" id="button_user_profil">
                <a  href="profil/<?=$idUser?> ">Voir Profil</a></button>
        </p>
        <?php if($infoObjet["typeAnnonce"]=="Pret"): ?>
        <p id="objet-dates"><strong>Dates de prêt :</strong> du <?= $infoObjet["debutPret"] ?> au <?= $infoObjet["finPret"] ?></p>
        <?php endif; ?>
        <?php if(valider("connecte","SESSION")): ?>
        <div class="contact">
            <p id="user-mail"><strong>Contact : </strong> <a href="mailto:<?= $userMail ?>"><?= $userMail ?></a></p>
            <p id="user-telephone"><strong>Telephone : </strong><?=$userTelephone?></p>
            <p id="user-adresse"><strong>Adresse : </strong><?=$infoUser["adresse"]?></p>
        </div>
         <?php endif; ?>
        <?php if($objetInfo[0]["idProprietaire"] == valider("idUser", "SESSION") || isModerateur(valider("idUser", "SESSION"))): ?>
        <div class="admin-options">
            <button class="btn"> <!-- not sure yet if the link will be js or done just with <a></a>-->
                <a href="annonce/<?=$idObjet?>/edit">
                    Modifier l'annonce </a>
            </button>

            <button class="btn" id="btnSupprimerAnnonce" >Supprimer l'annonce</button>
        </div>
    <?php endif; ?>
    </div>
</div>



<script>
  let slideIndex = 1;
  showSlides(slideIndex);

  function plusSlides(n) {
    showSlides(slideIndex += n);
  }

  function currentSlide(n) {
    showSlides(slideIndex = n);
  }

 function showSlides(n) {
   let i;
   let slides = document.getElementsByClassName("mySlides");
   let dots = document.getElementsByClassName("demo");

   if (n > slides.length) { slideIndex = 1 }
   if (n < 1) { slideIndex = slides.length }

   for (i = 0; i < slides.length; i++) {
     slides[i].style.display = "none";
   }
   for (i = 0; i < dots.length; i++) {
     dots[i].className = dots[i].className.replace(" active", "");
   }

   slides[slideIndex - 1].style.display = "block";

   if (dots.length > 0 && dots[slideIndex - 1]) {
     dots[slideIndex - 1].className += " active";
   }
 }


  $(document).ready(function() {
    // Gestion de la suppression de l'annonce
    $("#btnSupprimerAnnonce").click(function() {
        if (confirm("Êtes-vous sûr de vouloir supprimer cette annonce ?")) {
            $.ajax({
                url: "api/supprimerObjet",
                type: "GET",
                data: { idObjet: <?= $idObjet ?> }, // Envoi de l'ID de l'objet à supprimer
                success: function(reponse) {
                  console.log(reponse);
                  //redirige vers la page  d'accueil
                  window.location.href = "accueil";
                },
                error: function() {
                    alert("Une erreur s'est produite lors de la suppression de l'annonce.");
                }
            });
        }
    });



  });//fin document ready 
</script>
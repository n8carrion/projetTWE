<?php
    include_once "libs/modele.php";

    $infoObjet = infoObjet($idObjet)[0];
    $nom = $infoObjet['nom'];
    $description = $infoObjet["description"] ;
    $idcat = $infoObjet['idCategorie'];
    $cat = getCategorie($idcat) ;
    $don = ($infoObjet['typeAnnonce'] =="Don") ;
    $images = getImagesByObjet($idObjet);
    $size = count($images);
    /*$image1 = choisirImageByOrder($idObjet, 1) ;
    $image2 = choisirImageByOrder($idObjet, 2) ;
    $image3 = choisirImageByOrder($idObjet, 3) ;
    $image4 = choisirImageByOrder($idObjet, 4) ;

    $mainImage = $image1[0]["hash"];
    $source1 = "uploads/imagesObjets/" . $mainImage  . ".jpg";
    $source2 = "uploads/imagesObjets/" . $image2[0]["hash"]  . ".jpg";
    $source3 = "uploads/imagesObjets/" . $image3[0]["hash"]  . ".jpg";
    */


    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $idObjet = $_POST['idObjet'] ?? -1;

        $nom = $_POST['nomObjet'] ?? '';
        $description = $_POST['ocontenuDescription'] ?? '';
        $categorieNom = $_POST['categorie'] ?? '';
        $typeAnnonce = ($_POST['typeAnnonce'] === 'Don') ? 'Don' : 'Prêt';
        $idProprietaire = $_SESSION['idUtilisateur'] ?? null;

        $statutObjet="Disponible";

        $idCategorie = SQLGetChamp("SELECT id FROM Categorie WHERE nom='$categorieNom'");


            // Modifier l'objet existant
            modifierObjet($idObjet, $nom, $description, $idCategorie, $typeAnnonce, $statutObjet);


        // Redirect to avoid resubmission
        header('Location: ' . $base . 'annonce/'.$idObjet); // Or wherever you want to go
        exit;
    }
    ?>



<form id="publication" action="" method="POST">
    <input type="hidden" name="idObjet" value="<?= htmlspecialchars($idObjet) ?>">
    <div class="container2">
        <div class="left"  >
                <?php if (empty($images)): ?>
                  <div class="mySlides">
                    <div class="numbertext">1 / 1</div>
                    <img src="uploads/imagesObjets/noimage.jpg" style="width:100%">
                  </div>
                <?php else: ?>
                  <?php foreach ($images as $index => $image): ?>
                    <div class="mySlides">
                      <div class="numbertext"><?= ($index + 1) . " / " .$size ?></div>
                      <img src="<?= "uploads/imagesObjets/" . $image["hash"] . ".jpg" ?>" style="width:100%">
                    </div>
                  <?php endforeach; ?>

                  <a class="prev" onclick="plusSlides(-1)">❮</a>
                  <a class="next2" onclick="plusSlides(1)">❯</a>

                  <div class="row">
                    <?php foreach ($images as $index => $image): ?>
                      <div class="column">
                        <img class="demo cursor" src="<?= "uploads/imagesObjets/" . $image["hash"] . ".jpg" ?>"
                             style="width:100%" onclick="currentSlide(<?= $index + 1 ?>)" alt="Slide <?= $index + 1 ?>">
                      </div>
                    <?php endforeach; ?>
                  </div>
                <?php endif; ?>
        </div>

    <div class="right">
      <div class="right-inner">
        <div class="right-left">
          <input name="nomObjet" value="<?= isset($nom) ? htmlspecialchars($nom) : '' ?>" type="text" placeholder="Nom de l'objet">

          <textarea name="ocontenuDescription" id="description" placeholder="contenu de la description"><?= isset($description) ? htmlspecialchars($description) : '' ?></textarea>

          <input type="button" value="Ajouter des photos">
        </div>

        <div class="right-right">
          <label for="categorieAnnonce">Catégorie :</label>
          <select name="categorie" id="categorieAnnonce">
            <option value="all">Toutes les catégorie</option>
            <?php
            $SQL = "SELECT DISTINCT nom FROM Categorie";
            $categories = parcoursRs(SQLSelect($SQL));
            foreach ($categories as $categorie) {
              $selected = (isset($cat) && $categorie["nom"]==$cat) ? "selected": "" ;
              echo '<option value="' . htmlspecialchars($categorie['nom']) .'"' . $selected .'>' . htmlspecialchars($categorie['nom']) . '</option>';
            }
            ?>
          </select>

          <div id="typeService">
            <label for="don">
              <input id="don" type="radio" value="Don" name="typeAnnonce" <?= (isset($don) && $don) ? "checked" : "" ?>> Pour Don
            </label>
            <label for="pret">
              <input id="pret" type="radio"  value="Prêt" name="typeAnnonce" <?= (isset($don) && $don==0) ? "checked" : "" ?>> Pour Prêter
            </label>

            <span id="texteDebut"> de</span>
            <input name="debutPret" id="debut" type="date">
            <span id="texteFin">Jusqu'à</span>
            <input name="FinPret" id="fin" type="date">

            <button type="button" id="resetAnnonce">Réinitialiser</button>

            <label for="toujours">
              <input id="toujours" type="checkbox" name="toujoursActive"> Toujours(jusqu'à desactisvation)
            </label>
          </div>
        </div>
      </div>

      <!-- Publier button centered below -->
      <div class="btn-publier-container">
        <input id="BtnPublier" class="btn" type="submit" value="Publier">
      </div>
    </div>


</div>
</form>



<script src="js/jquery-3.7.1.min.js">
</script>
<script>
    const objet = <?= json_encode($idObjet) ?>;
    let slideIndex = 1;
    if(objet!=-1){ showSlides(slideIndex);}


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
      //let captionText = document.getElementById("caption");
      if (n > slides.length) {slideIndex = 1}
      if (n < 1) {slideIndex = slides.length}
      for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
      }
      for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
      }
      slides[slideIndex-1].style.display = "block";
      dots[slideIndex-1].className += " active";
      //captionText.innerHTML = dots[slideIndex-1].alt;
    }
    $('#resetAnnonce').click(function () {
    // Décocher les radios
    $('#don').prop('checked', false);
    $('#pret').prop('checked', false);

    // Réafficher les labels
    $('#don').closest('label').show();
    $('#pret').closest('label').show();

    // Réafficher les dates et leurs textes
    $('#debut').show();
    $('#fin').show();
    $('#texteDebut').show();
    $('#texteFin').show();
});

$(document).ready(function () {
    $('input[name="typeAnnonce"]').change(function () {
        if ($('#don').is(':checked')) {
            $('#pret').closest('label').hide();

            $('#debut').hide();
            $('#fin').hide();
            $('#texteDebut').hide();
            $('#texteFin').hide();

            $('#don').closest('label').show();
        }

        if ($('#pret').is(':checked')) {
            $('#don').closest('label').hide();

            $('#debut').show();
            $('#fin').show();
            $('#texteDebut').show();
            $('#texteFin').show();

            $('#pret').closest('label').show();
        }
    });
});
</script>
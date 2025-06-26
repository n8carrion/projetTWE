<?php
    include_once "libs/modele.php";
    if ($idObjet>0) {
    $infoObjet = infoObjet($idObjet)[0];
    $nom = $infoObjet['nom'];
    $description = $infoObjet["description"] ;
    $idcat = $infoObjet['idCategorie'];
    $cat = getCategorie($idcat) ;
    $don = ($infoObjet['typeAnnonce'] =="Don") ;
    $images = getImagesByObjet($idObjet);
    $size = count($images);
    $image1 = choisirImageByOrder($idObjet, 1) ;
    $image2 = choisirImageByOrder($idObjet, 2) ;
    $image3 = choisirImageByOrder($idObjet, 3) ;
    $image4 = choisirImageByOrder($idObjet, 4) ;
    /*
    $mainImage = $image1[0]["hash"];
    $source1 = "uploads/imagesObjets/" . $mainImage  . ".jpg";
    $source2 = "uploads/imagesObjets/" . $image2[0]["hash"]  . ".jpg";
    $source3 = "uploads/imagesObjets/" . $image3[0]["hash"]  . ".jpg";
    */
    }
    ?>



<form id="publication" action="controleur.php" method="GET">
<div id="infos">
<input name="nomObjet" value="<?= isset($nom) ? htmlspecialchars($nom) : '' ?>" type="text" placeholder="Nom de l'objet">
<textarea name="ocontenuDescription" id="description" placeholder="contenu de la description">
<?= isset($description) ? htmlspecialchars($description) : '' ?>
</textarea>
<label for="categorieAnnonce">Catégorie :</label>
        <select name="categorie" id="categorieAnnonce">
          <option value="all">Toutes les catégorie</option>
            <?php
            // On récupère les catégories d'objets depuis la base de données
            $SQL = "SELECT DISTINCT nom FROM Categorie";
            $categories = parcoursRs(SQLSelect($SQL));
            // On affiche chaque catégorie dans une option du select
            
            foreach ($categories as $categorie) {
                $selected = (isset($cat) && $categorie["nom"]==$cat) ? "selected": "" ;
                echo '<option value="' . htmlspecialchars($categorie['nom']) .'"' . $selected .'>' . htmlspecialchars($categorie['nom']) . '</option>';
            }
            ?>

        </select>
<input type="button" value="Ajouter des photos">
</div>
<div id="typeService">
<label for="don">
<input id="don" type="radio" name="typeAnnonce" 
<?php if(isset($don) && $don) echo "checked";?>>
 Pour Don 
</label>
<label for="pret">
<input id="pret" type="radio" name="typeAnnonce"
<?php if(isset($don) && $don==0) echo "checked";?>>
 Pour Prêter 
</label>
    <span id="texteDebut"> de</span>
    <input name="debutPret" id="debut" type="date">
    <span id="texteFin">Jusqu'à</span>
    <input name="FinPret" id="fin" type="date">
    <button type="button" id="resetAnnonce">Réinitialiser</button>
    <label for="toujours">
    <input id="toujours" type="checkbox" name="typeAnnonce">
    Toujours(jusqu'à desactisvation) 
    </label>
</div>
<input id="BtnPublier" class="btn" type="submit" value="Publier">

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
    </div>

</form>



<script src="js/jquery-3.7.1.min.js">
</script>
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
<?php
include_once "libs/modele.php";

$infoObjet = infoObjet($idObjet)[0];
$nom = $infoObjet['nom'];
$description = $infoObjet["description"];
$idcat = $infoObjet['idCategorie'];
$cat = getCategorie($idcat);
$don = ($infoObjet['typeAnnonce'] == "Don");
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
  $ordreImages = $_POST['ordreImages'] ?? '';
  $typeAnnonce = ($_POST['typeAnnonce'] === 'Don') ? 'Don' : 'Prêt';
  $idProprietaire = $_SESSION['idUtilisateur'] ?? null;

  $statutObjet = "Disponible";

  $idCategorie = SQLGetChamp("SELECT id FROM Categorie WHERE nom='$categorieNom'");


  // Modifier l'objet existant
  modifierObjet($idObjet, $nom, $description, $idCategorie, $typeAnnonce, $statutObjet);

  orderImages($ordreImages);

  // Redirect to avoid resubmission
  header('Location: ' . $base . 'annonce/' . $idObjet); // Or wherever you want to go
  exit;
}
?>

<link rel="stylesheet" href="css/jquery-ui.min.css">

<style>
    .right-inner {
      display: flex;
      flex-direction: row;
      gap: 32px; /* espace entre les deux colonnes, ajuste si besoin */
  }
  
  .right-left {
      flex: 2;
      min-width: 0;
  }
  
  .right-right {
      flex: 1;
      min-width: 200px; /* ajuste selon le rendu souhaité */
  }

  

</style>
<div class="container2">
  <div>
    <fieldset id="divAjoutImages">
      <legend>Ajout des images</legend>
        <div>
          <ul id="sortable">
            <?php foreach ($images as $image): ?>
              <li class="ui-state-default" data-id="<?= $image["id"] ?>">
                <img src="<?= "uploads/imagesObjets/" . $image["hash"] . ".jpg" ?>">
                <input type="button" value=supprimer class="deletebtn">
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
          <form id="imageUploadForm">
            Sélectionner l'image à ajouter :
            <input type="file" name="imageToUpload" accept=".jpg,.jpeg,.png,.gif" id="imageToUpload">
            <input type="button" value="Ajout Image" name="Ajouter l'image" id="ajouterImage" />
            <p id="status"></p>
          </form>
        </div>
  </fieldset>

  <fieldset>
    <legend>Ajout infos de l'annonce</legend>
    <form id="publication" action="" method="POST">
      <input type="hidden" name="idObjet" value="<?= htmlspecialchars($idObjet) ?>">
      <input id="ordreImages" type="hidden" name="ordreImages" value="<?php foreach ($images as $image) echo $image["id"] . ','; ?>">
      <div class="right-inner">
        <div class="right-left">
          <input name="nomObjet" value="<?= isset($nom) ? htmlspecialchars($nom) : '' ?>" type="text" placeholder="Nom de l'objet">

          <textarea name="ocontenuDescription" id="description" placeholder="contenu de la description"><?= isset($description) ? htmlspecialchars($description) : '' ?></textarea>

          <!-- <input type="button" value="Ajouter des photos"> -->
        </div>

        <div class="right-right">
          <label for="categorieAnnonce">Catégorie :</label>
          <select name="categorie" id="categorieAnnonce">
            <?php
            $SQL = "SELECT DISTINCT nom FROM Categorie";
            $categories = parcoursRs(SQLSelect($SQL));
            foreach ($categories as $categorie) {
              $selected = (isset($cat) && $categorie["nom"] == $cat) ? "selected" : "";
              echo '<option value="' . htmlspecialchars($categorie['nom']) . '"' . $selected . '>' . htmlspecialchars($categorie['nom']) . '</option>';
            }
            ?>
          </select>

            <div id="typeService">
            <label>
              <input id="don" type="radio" value="Don" name="typeAnnonce" <?= (isset($don) && $don) ? "checked" : "" ?>> Don
            </label>
            <label>
              <input id="pret" type="radio" value="Prêt" name="typeAnnonce" <?= (isset($don) && !$don) ? "checked" : "" ?>> Prêt
            </label>
          </div>
           <div id="datesPret" style="display: <?= (isset($don) && !$don) ? 'block' : 'none' ?>; margin-top:8px;">
              <span id="texteDebut">De</span>
              <input name="debutPret" id="debut" type="date">
              <span id="texteFin">Jusqu'à</span>
              <input name="FinPret" id="fin" type="date">
              <label for="toujours" style="margin-left:10px;">
                <input id="toujours" type="checkbox" name="toujoursActive"> Toujours (jusqu'à désactivation)
              </label>
            </div>
        </div>
        </fieldset>


      
      <div class="btn-publier-container">
        <input id="BtnPublier" class="btn" type="submit" value="Publier">
      </div>
    </form>
  </div>
</div>


<script src="js/jquery-3.7.1.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script>
  const objet = <?= json_encode($idObjet) ?>;


  $(document).ready(function() {

        $(document).ready(function() {
      function toggleDatesPret() {
        if ($('#pret').is(':checked')) {
          $('#datesPret').show();
        } else {
          $('#datesPret').hide();
        }
      }
    
      // Initialisation au chargement
      toggleDatesPret();
    
      // Sur changement de radio
      $('input[name="typeAnnonce"]').change(toggleDatesPret);
    
      // ... (le reste de ton code déjà présent)
    });
    
 

    $("#sortable").on("click", ".deletebtn", function() {
      if (confirm("Êtes-vous sûr de vouloir supprimer cette image ?")) {
        $.ajax({
          url: "api/supprimerImage",
          type: "GET",
          data: {
            idImage: $(this).parent().data("id")
          }, // Envoi de l'ID de l'objet à supprimer
          success: function(reponse) {
            console.log(reponse);
          },
          error: function() {
            alert("Une erreur s'est produite lors de la suppression de l'image.");
          }
        });
        $(this).parent().remove();
        $("#sortable").sortable("refresh");
        updateOrdreImages();
      }
    })
  });

  // Pour la gestion des images

  function updateOrdreImages() {
    ordreimages = "";
    $('#sortable').children().each(function() {
      ordreimages += $(this).data("id") + ",";
    });
    $('#ordreImages').val(ordreimages);
  }

  $(function() {
    $("#sortable").sortable({
      update: updateOrdreImages
    });
  });

  const ajouterImage = document.getElementById('ajouterImage'); // Our HTML form's ID
  const myFile = document.getElementById('imageToUpload'); // Our HTML files' ID
  const statusP = document.getElementById('status');

  ajouterImage.onclick = function(event) {
    event.preventDefault();

    statusP.innerHTML = 'Téléversement...';

    // Get the files from the form input
    const files = myFile.files;
    if (files.length == 0) {
      statusP.innerHTML = 'Pas d\'image sélectionnée !';
      return;
    }
    // Create a FormData object
    const formData = new FormData();

    // Select only the first file from the input array
    const file = files[0];

    // Add the file to the AJAX request
    formData.append('fileAjax', file, file.name);

    // Set up the request
    const xhr = new XMLHttpRequest();

    // Open the connection
    xhr.open('POST', 'api/uploadImage/<?= $idObjet ?>', true);

    // Set up a handler for when the task for the request is complete
    xhr.onload = function() {
      if (xhr.status == 200) {
        const responseArray = xhr.response.split(",");
        statusP.innerHTML = responseArray[0];
        if (responseArray[0] == "L'image a été téléversé") {
          $("#sortable").append('<li class="ui-state-default" data-id="' + responseArray[2] + '"><img src="uploads/imagesObjets/' + responseArray[1] + '.jpg"><input type="button" value=supprimer class="deletebtn"></li>');
          $("#sortable").sortable("refresh");
          updateOrdreImages();

          console.log("success");
        }
      } else {
        statusP.innerHTML = 'Erreur de téléversement, veuillez réessayer';
      }
    };

    // Send the data.
    xhr.send(formData);
  }
</script>
<script src="js/jquery-3.7.1.min.js"></script>
<script src="js/annonces.js"></script>

<script>
const idUtilisateur = <?= json_encode($userInfo[0]["id"]) ?>;

$(document).ready(function() {
    // Charge les annonces de cet utilisateur
    chargerAnnonces({ utilisateur: idUtilisateur });
});
</script>

<?php
include_once("libs/modele.php");
?>

<section class="profile-info-box" style="background-color: #fff; padding: 1.5em; border-radius: 8px;">
  <h2><?=$userString?></h2>

  <p><a href="<?= $userInfo[0]['facebook'] ?>">Facebook</a></p>
  <p><a href="mailto:<?= $userInfo[0]['mail'] ?>">Email : <?=$userInfo[0]["mail"]?></a></p>
  <p><?= $userInfo[0]["telephone"] ?></p>
</section>

<!-- ici même code que catalogue mais adapté-->

<fieldset>
    <legend>Les annonces de </legend>
    <div id="annonces">
        <!-- Les cartes seront ajoutées ici grace à chargerAnnonces -->
    </div>
</fieldset>

 <div>
    <!-- On affiche un message si aucune annonce n'est trouvée -->
        <h2 id="messageAucunObjet" style="display : none; color: red; text-align : center;">Aucune annonce trouvée...</h2>
</div>




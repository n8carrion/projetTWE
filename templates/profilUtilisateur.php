<script src="js/jquery-3.7.1.min.js"></script>
<script src="js/annonces.js"></script>

<script>
const idUtilisateur = <?= json_encode($idProfil) ?>;
console.log(idUtilisateur);
$(document).ready(function() {
    // Charge les annonces de cet utilisateur
    chargerAnnonces({ utilisateur: idUtilisateur });
});
</script>

<?php
include_once("libs/modele.php");
$infoUser =infoUtilisateur($idProfil)[0];
$userString = $infoUser['prenom'] ." ". $infoUser['nom'];
?>

<section class="profile-info-box" style="background-color: #fff; padding: 1.5em; border-radius: 8px;">
  <h2><?=$userString?></h2>
<?php if (!empty($infoUser['facebook'])): ?>
  <p class="btn"><a href="<?= $infoUser['facebook'] ?>" target="_blank">Aller sur son profil Facebook</a></p>
<?php else: ?>
  <p>L'utilisateur n'a pas renseigné son profil Facebook.</p>
<?php endif; ?>
   <?php if(valider("connecte","SESSION")): ?>
  <p><strong>Email</strong> : <a href="mailto:<?= $infoUser['mail'] ?>"><?=$infoUser["mail"]?></a></p>
  <p><strong>Telephone</strong> : <?= $infoUser["telephone"] ?></p>
  <p><strong>Adresse</strong>: <?= $infoUser["adresse"] ?></p>
  <?php else: ?>
  <p>Tu dois être connecté pour voir ses informations de contact!</p>
<?php endif; ?>
 <?php if ($idProfil == valider("idUser", "SESSION")): ?>
<button class="btn"><a href="profil/edit">Modifier profil </a> </button>
<?php endif; ?>
</section>

<!-- ici même code que catalogue mais adapté-->

<fieldset>
    <legend>Les annonces de <?=$userString?> </legend>
    <div id="annonces">
        <!-- Les cartes seront ajoutées ici grace à chargerAnnonces -->
    </div>
</fieldset>

 <div>
    <!-- On affiche un message si aucune annonce n'est trouvée -->
        <h2 id="messageAucunObjet" style="display : none; color: red; text-align : center;">Aucune annonce trouvée...</h2>
</div>




<?php
include_once("libs/modele.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Procesar modificación
    $mail = $_POST['mail'] ?? '';
    $telephone = $_POST['telephone'] ?? '';
    $adresse = $_POST['adresse'] ?? '';
    $facebook = $_POST['facebook'] ?? '';

    modifierUtilisateur($idProfil, $mail, $telephone, $adresse, $facebook);

    // Opcional: actualizar datos en sesión
    /*$_SESSION['user']['mail'] = $mail;
    $_SESSION['user']['telephone'] = $telephone;
    $_SESSION['user']['adresse'] = $adresse;
    $_SESSION['user']['facebook'] = $facebook;*/

    header('Location: ' . $base . 'profil'); //Redirige a la página de perfil
    exit;
}

$infoUser =infoUtilisateur($idProfil)[0];
$userString = $infoUser['prenom'] ." ". $infoUser['nom'];
?>



  <section class="profile-info-box" style="background-color: #fff; padding: 1.5em; border-radius: 8px;">
    <h2><?= $userString ?></h2>
    <form method="POST" action="">
      <p>Facebook : <input style="width: 400px;" name="facebook" value="<?= htmlspecialchars($infoUser['facebook'] ?? '') ?>"></p>
      <p>Email : <input style="width: 400px;" name="mail" value="<?= htmlspecialchars($infoUser['mail'] ?? '') ?>"></p>
      <p>Telephone : <input name="telephone" value="<?= htmlspecialchars($infoUser['telephone'] ?? '') ?>"></p>
      <p>Adresse : <input name="adresse" value="<?= htmlspecialchars($infoUser['adresse'] ?? '') ?>"></p>
      <input class="btn" type="submit" value="Sauvegarder">
      <a href="profil"><input class="btn" type="button" value="Annuler"></a>
    </form>
  </section>



<script src="js/jquery-3.7.1.min.js">
</script>

<script>
    $(document).ready(function (){
        $("#btnGarder").click(function(){
            var params ={

            facebook:$("#facebookUser").val(),
            mail: $("#mailUser").val(),
            telephone:$("#telephoneUser").val(),
            adresse:$("#adresseUser").val()
            }




        });// FIN BTN Sauvegarder

        $("#btnCancel").click(function () {
                    window.location.href = "profil"; // Cancelar vuelve al perfil
                });

    });
</script>
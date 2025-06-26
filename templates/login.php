<h1>Connexion</h1>
<a class="btn" style="background-color : darkgreen !important;" href="https://centralelilleassos.fr/authentification/larezerve">Connexion  via CLA</a>
<?php
include_once("config.php");
if (!$PROD) {
    echo "<br><a class='btn' href=\"login/fix/jeanne.boucher\">Connexion  comme jeanne.boucher</a>";
    echo "<br><a class='btn' href=\"login/fix/valentin.gregoire\">Connexion  comme valentin.gregoire</a>";
    echo "<br><a class='btn' href=\"login/fix/william.tan\">Connexion  comme william.tan</a>";
}
?>
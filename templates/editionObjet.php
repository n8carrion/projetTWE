<?php
    include_once "libs/modele.php";
    $infoObjet = infoObjet($idObjet)[0];
    $nom = $infoObjet['nom'];
    $description = $infoObjet["description"] ;
    $don = ($infoObjet['typeAnnonce'] =="Don") ;
    $image1 = choisirImageByOrder($idObjet, 1) ;
    $image2 = choisirImageByOrder($idObjet, 2) ;
    $image3 = choisirImageByOrder($idObjet, 3) ;
    $image4 = choisirImageByOrder($idObjet, 4) ;
    $mainImage = $image1[0]["hash"];
    $source1 = "uploads/imagesObjets/" . $mainImage  . ".jpg";
    $source2 = "uploads/imagesObjets/" . $image2[0]["hash"]  . ".jpg";
    $source3 = "uploads/imagesObjets/" . $image3[0]["hash"]  . ".jpg";
?>

<form id="publication" action="controleur.php" method="GET">
<div id="infos">
<input name="nomObjet" value="<?=$nom?>" type="text" placeholder="Nom de l'objet">
<textarea name="ocontenuDescription" id="description" placeholder="contenu de la description">
<?=$description?>
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
                echo '<option value="' . htmlspecialchars($categorie['nom']) . '">' . htmlspecialchars($categorie['nom']) . '</option>';
            }
            ?>
        </select>
<input type="button" value="Ajouter des photos">
</div>
<div id="typeService">
<label for="don">
<input id="don" type="radio" name="typeAnnonce">
 Pour Don 
</label>
<label for="pret">
<input id="pret" type="radio" name="typeAnnonce">
 Pour Prêter 
</label>
    de 
    <input name="debutPret" id="debut" type="date">
    Jusqu'à
    <input name="FinPret" id="fin" type="date">
    <label for="toujours">
    <input id="toujours" type="checkbox" name="typeAnnonce">
    Toujours(jusqu'à desactisvation) 
    </label>
</div>
<input id="BtnPublier" class="btn" type="submit" value="Publier">
</form>

<form id="publication" action="" method="GET">
<div id="infos">
<input name="nomObjet" type="text" placeholder="Nom de l'objet">
<textarea id="description" placeholder="contenu de la description">
</textarea>

<input type="button" value="Ajouter des photos">
</div>
<div id="typeService">
<label for="don">
<input id="don" type="radio" name="type">
 Pour Don 
</label>
<label for="pret">
<input id="pret" type="radio" name="type">
 Pour Prêter 
</label>
    de 
    <input id="debut" type="date">
    Jusqu'à
    <input id="fin" type="date">
    <label for="toujours">
    <input id="toujours" type="checkbox" name="type">
    Toujours(jusqu'à desactisvation) 
    </label>
</div>
<input id="BtnPublier" class="btn" type="button" value="Publier">
</form>
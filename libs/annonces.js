



//Fonction pour créer une carte d'objet, qui sera ensuite ajoutée au catalogue 
// Cette fonction est appelée pour chaque objet reçu de la requête AJAX
    function mkCarteObjet(oObjet) {

        var carte = $('<div class="carteObjet"></div>');
        var lien = $('<a></a>').attr('href', 'annonce/' + oObjet.id);

        //Image, si il n'y a pas d'image, on met une image par défaut
        var imgSrc = (oObjet.images && oObjet.images.length > 0)
         ? 'uploads/imagesObjets/' + oObjet.images[0].hash +".jpg"
         : 'ressources/noImage.jpg';
        var img = $('<img>').attr('src', imgSrc).attr('alt', 'Photo de l’objet');

        var titreCarte = $('<h2></h2>').text(oObjet.nom);


        var details = $('<p></p>').html('<strong>Type :</strong> ' + oObjet.typeAnnonce + '<br>' +
            '<strong>Catégorie :</strong> ' + oObjet.categorieObjet + '<br>' +
            '<strong>Statut :</strong> ' + oObjet.statutObjet);

        // Assembler la carte
        lien.append(img, titreCarte, details);
        carte.append(lien);

        return carte;

    }

function chargerAnnonces(params, idCible) {
    $.ajax({
        url: 'api/listerObjet',
        type: 'GET',
        dataType: 'json',
        data: params,
        success: function(reponse) {
            $(idCible).empty();
            $.each(reponse, function(index, oObjet) {
                var carte = mkCarteObjet(oObjet);
                $(idCible).append(carte);
            });
            if ($(idCible).children().length === 0 && $('#messageAucunObjet').length) {
                $('#messageAucunObjet').show();
            } else if ($('#messageAucunObjet').length) {
                $('#messageAucunObjet').hide();
            }
        },
        error: function(xhr, status, error) {
            console.error("Erreur lors de la récupération des objets ", xhr.responseText, status, error);
        }
    });
}


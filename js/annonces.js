

//Fonction pour créer une carte d'objet, qui sera ensuite ajoutée au catalogue 
// Cette fonction est appelée pour chaque objet reçu de la requête AJAX
console.log("Chargement du script annonces.js qui contient mkCarteObjet et chargerAnnonces");
function mkCarteObjet(oObjet) {

        var carte = $('<div class="carteObjet"></div>');
        var lien = $('<a></a>').attr('href', 'annonce/' + oObjet.id);

        //Image, si il n'y a pas d'image, on met une image par défaut
        var imgSrc = (oObjet.images && oObjet.images.length > 0)
         ? 'uploads/imagesObjets/' + oObjet.images[0].hash +".jpg"
         : 'ressources/noImage.jpg';
        var img = $('<img>').attr('src', imgSrc).attr('alt', 'Photo de l’objet');

        var titreCarte = $('<h2></h2>').text(oObjet.nom);


        var details = $('<p></p>')
                    .append(
                        $('<div class="elemCarte"></div>')
                            .append('<div class="etiquette" >Type :</div>')
                            .append('<div>' + oObjet.typeAnnonce + '</div>')
                    )
                    .append(
                        $('<div class="elemCarte"></div>')
                            .append('<div class="etiquette">Catégorie :</div>')
                            .append('<div>' + oObjet.categorieNom + '</div>')
                    )
                    .append(
                        $('<div class="elemCarte"></div>')
                            .append('<div class="etiquette">Statut :</div>')
                            .append('<div>' + oObjet.statutObjet + '</div>')
                    );

        // Assembler la carte
        lien.append(img, titreCarte, details);
        carte.append(lien);

        return carte;

    }

//Fonction pour charger les annonce dans un element d'id "annonces"
//params (qui est un objet json) sera donné à la fonction listerObjet de l'API contenu dans api/listerObjet
//ne pas oublier dans la page en question d'avoir la librairie jQuery et annonce.js
function chargerAnnonces(params) {
    $.ajax({
        url: 'api/listerObjet',
        type: 'GET',
        dataType: 'json',
        data: params,
        success: function(reponse) {
            $("#annonces").empty();
            $.each(reponse, function(index, oObjet) {
                var carte = mkCarteObjet(oObjet);
                $("#annonces").append(carte);
            });
            if ($("#annonces").children().length === 0 && $('#messageAucunObjet').length) {
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


<div class="container">
    <div class="left">
        <div class="main-image">
            <img src="uploads/imagesObjets/1_1.jpg" alt="Image principale" class="main-img">
        </div>
        <div class="thumbnails">
            <div></div>
            <div></div>
            <div></div> <!-- this here can be changed to img, then in <style> would be .thumbnails img-->
        </div>
    </div>

    <div class="details">
        <h2 id="objet-nom">NOM D'OBJET</h2>
        <p id="statutObjet">À donner : DISPONIBLE</p>

        <p><strong>Description :</strong></p>
        <p id="objet-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris placerat justo non est suscipit, nec dictum massa dictum.</p>

        <p id="categorieObjet"><strong>Catégorie :</strong> Meuble</p>
        <p id=objet-typeAnnonce><strong>Type :</strong> Don</p>

        <p>
            <strong>Publié par :</strong>User123
            <button id="button_user_profil">Voir Profil</button>
        </p>

        <p id="objet-dates"><strong>Dates de prêt :</strong> du 01/07/2025 au 15/07/2025</p>

        <div class="contact">
            <p id="user-adresse"><strong>Contact :</strong> mail@mail.com</p>
            <p id="user-telephone">+33 0 01 23 45 67</p>
        </div>

        <div class="admin-options">
            <button> <!-- not sure yet if the link will be js or done just with <a></a>-->
                <a href="index.php?view=editionObjet&id=1">
                    Modifier l'annonce </a>
            </button>

            <button>Supprimer l'annonce</button>
        </div>
    </div>
</div>
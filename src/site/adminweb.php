<?php include('partiels/navbar_adminweb.php'); ?>
<main role="main">

    <section class="description text-center">
        <div class="titre text-center">
            <h1>Accueil de l'Administrateur Web</h1>
            <p>Bienvenue dans votre espace d'administration. Cet espace est réservé à l'administrateur web, qui dispose de toutes les fonctionnalités nécessaires pour gérer les utilisateurs de la plateforme.</p>

            <h2>Fonctionnalités disponibles :</h2>
            <ul>
                <li>Afficher la liste complète des utilisateurs inscrits.</li>
                <li>Créer un nouvel utilisateur manuellement.</li>
                <li class="json-class">Importer plusieurs utilisateurs automatiquement à partir d’un fichier au format <strong>JSON</strong>.</li>
                <li>Supprimer un ou plusieurs utilisateurs ainsi que tout leur historique associé.</li>
            </ul>

            <h3>Informations de connexion de l’administrateur :</h3>
            <p>Nom d'utilisateur : <strong>adminweb</strong> — Mot de passe : <strong>adminweb</strong></p>
            <p class="text-danger"><em>Ces identifiants sont fixes et ne doivent pas être modifiés.</em></p>

        </div>
    </section>

</main>

<?php include('partiels/footer.php') ?>



<!-- --------------CSS intégré directement sur le fichier car style.css surchargé----------------------- -->
<style>


    .description {
        background-color: #ffffff;
        padding: 40px 20px;
        margin: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        flex-grow: 1;
        box-sizing: border-box;
    }


    .titre h1 {
        font-size: 2.5rem;
        color: #007bff;
        margin-bottom: 20px;
    }


    .titre p {
        font-size: 1.2rem;
        line-height: 1.6;
        margin-bottom: 20px;
    }


    ul {
        list-style-type: disc;
        margin-left: 40px;
        margin-bottom: 20px;
    }

    ul li {
        font-size: 1.1rem;
        margin-bottom: 10px;
    }


    strong {
        color: #007bff;
    }

    .json-class strong{
        color: #0a4482;
    }

    footer {
        text-align: center;
        padding: 20px;
        background-color: #333;
        color: #fff;
        margin-top: auto;
    }
</style>

</body>
</html>

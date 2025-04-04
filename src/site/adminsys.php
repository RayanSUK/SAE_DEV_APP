<?php include('partiels/navbar_adminsys.php'); ?>
<title>Administrateur Système</title>

<main role="main">
<section class="description text-center">
    <div class="titre text-center">
        <h1>Accueil de l' Admin Système</h1>
        <p>Bienvenue dans votre espace Administrateur Système. En tant qu'administrateur système, vous avez accès aux fichiers de journalisation de la plateforme.</p>
        <h2>Voici ce que vous pouvez faire :</h2>
        <ul>
            <li>Consulter et filtrer le fichier de journalisation</li>
            <li>Exporter en .json le journal d'activités</li>
            <li>Supprimer le journal d'activités</li>
            <li>Afficher un fichier de logs .json dans l'interface web</li>
        </ul>
        <p>Veuillez noter que vos identifiants d'accès sont fixes (login : <strong>adminsys</strong>, mot de passe : <strong>adminsys</strong>) et ne doivent pas être modifiés.</p>
    </div>
</section>
</main>

<?php include('partiels/footer.php') ?>



<!-- --------------CSS intégré directement sur le fichier car style.css surchargé----------------------- -->
<style>

    body, html {
        margin: 0;
        padding: 0;
        height: 100%;
        display: flex;
        flex-direction: column;
    }


    body {
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
        color: #333;
        flex-grow: 1;
    }


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

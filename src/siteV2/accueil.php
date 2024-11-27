<?php
session_start();
?>

<?php include('partiels/navbar.php'); ?>

<!-- la section accueil commence ici-->
<section class="text-center">
    <div class="titre text-center">
    <?php
if (isset($_SESSION['etat'])) {
    if ($_SESSION['etat'] === 'inscription') {
        echo "<h1>Bienvenue parmi nous, " . htmlspecialchars($_SESSION['nom']) . " !</h1>";
    } elseif ($_SESSION['etat'] === 'connexion') {
        echo "<h1>Te revoilà parmi nous, " . htmlspecialchars($_SESSION['nom']) . " !</h1>";
    }
    unset($_SESSION['etat']); // Réinitialiser après affichage
}
?>
    </div>


    <div class="video">
        <iframe width='1080' height='560' src='https://www.youtube.com/embed/G5RpJwCJDqc' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
    </div>
 </section>
<!-- la section accueil se termine ici-->


<!-- la section explication commence ici-->
<section class="presentation-site">
    <div class="container">
        <h1>Présentation du Site</h1>
        <p>
            Bienvenue sur notre plateforme éducative et interactive dédiée aux mathématiques appliquées. Ce site 
            est spécialement conçu pour explorer et comprendre des concepts avancés comme la <strong>loi inverse gaussienne</strong>. 
            Voici un aperçu de ce que vous pouvez faire :
        </p>

        <h2>Fonctionnalités principales</h2>
        <ul>
            <li>
                <strong>Connexion sécurisée :</strong> Accédez à l'application avec un identifiant et un mot de passe. 
                Selon votre rôle (<em>sysadmin</em> ou <em>admin web</em>), vous avez des droits spécifiques.
            </li>
            <li>
                <strong>Calculs interactifs :</strong> Entrez vos paramètres pour tracer des graphiques basés sur la loi inverse gaussienne 
                et visualisez les résultats directement.
            </li>
            <li>
                <strong>Gestion des utilisateurs :</strong> Les administrateurs peuvent visualiser et gérer les informations des utilisateurs 
                enregistrées dans des fichiers CSV.
            </li>
        </ul>

        <h2>Comment ça fonctionne ?</h2>
        <p>
            Pour commencer, connectez-vous avec vos identifiants. Une fois connecté(e), vous pouvez naviguer entre les différentes sections :
        </p>
        <ol>
            <li><strong>Calculs :</strong> Accédez à l'outil interactif pour explorer les propriétés de la loi inverse gaussienne.</li>
            <li><strong>Gestion des utilisateurs :</strong> Administrez les données directement à partir d'une interface intuitive.</li>
        </ol>

        <h2>À propos de la Loi Inverse Gaussienne</h2>
        <p>
            La loi inverse gaussienne est une distribution de probabilité utilisée en statistiques. Elle est souvent 
            appliquée pour modéliser des durées ou des processus aléatoires dépendant de plusieurs facteurs. 
            Sur ce site, vous pouvez explorer sa densité de probabilité et mieux comprendre ses caractéristiques.
        </p>
    </div>
</section>


<!-- la section explication se termine ici-->

<?php include('partiels/footer.php'); ?>

</body>
</html>

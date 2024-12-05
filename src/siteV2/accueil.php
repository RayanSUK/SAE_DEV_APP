<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: accueil_non_inscrit.php");
    exit;
}
?>

<?php include('partiels/navbar.php'); ?>

<!-- la section accueil commence ici-->
<section class="text-center">
    <div class="titre text-center">
        <?php
        // Vérifier si la session contient 'login' et 'user_id'
        if (isset($_SESSION['login'], $_SESSION['user_id'])) {
            $login = htmlspecialchars($_SESSION['login']);  // Utiliser le login stocké dans la session

            if ($_SESSION['etat'] === 'inscription') {
                echo "<h1>Bienvenue parmi nous, $login !</h1>";
            } elseif ($_SESSION['etat'] === 'connexion') {
                echo "<h1>Te revoilà parmi nous, $login !</h1>";
            }

            // Réinitialiser la variable de session après affichage
            unset($_SESSION['etat']);
        } else {
            echo "<h1>Veuillez vous connecter pour accéder à cette page.</h1>";
        }
        ?>
    </div>
</section>


<!-- la section accueil se termine ici-->


<!-- la section accueil se termine ici-->


<!-- la section explication commence ici-->
<section class="presentation-site">
    <div class="container">
        <h1>Présentation du Site</h1>
        <p>
            Bienvenue sur notre plateforme interactive dédiée à l'exploration des mathématiques appliquées. Ce site 
            a été conçu pour vous aider à comprendre des concepts avancés de manière simple et visuelle. Plongez dans 
            le monde fascinant des mathématiques avec des outils faciles à utiliser !
        </p>

        <h2>Fonctionnalités principales</h2>
        <ul>
            <li>
                <strong>Connexion personnalisée :</strong> Créez votre compte pour accéder à toutes les fonctionnalités et sauvegarder vos paramètres.
            </li>
            <li>
                <strong>Calculs interactifs :</strong> Entrez vos données pour générer des graphiques dynamiques et explorer des modèles mathématiques comme 
                la <strong>loi inverse gaussienne</strong>.
            </li>
            <li>
                <strong>Exploration visuelle :</strong> Obtenez des explications claires et des représentations graphiques pour mieux comprendre les concepts.
            </li>
        </ul>

        <h2>Comment ça fonctionne ?</h2>
        <p>
            Pour commencer, inscrivez-vous ou connectez-vous à votre espace personnel. Une fois connecté(e), vous pouvez explorer les différentes sections du site :
        </p>
        <ol>
            <li><strong>Calculs :</strong> Utilisez notre outil interactif pour découvrir les propriétés mathématiques en quelques clics.</li>
            <li><strong>Graphiques :</strong> Visualisez des données de manière intuitive pour approfondir votre compréhension.</li>
        </ol>

        <h2>À propos de la Loi Inverse Gaussienne</h2>
        <p>
            La loi inverse gaussienne est une distribution de probabilité utilisée pour modéliser des phénomènes comme des durées ou des processus dépendants 
            de plusieurs facteurs. Avec notre outil, vous pouvez explorer sa densité de probabilité et ses caractéristiques à travers des graphiques interactifs.
        </p>
    </div>
</section>


<!-- la section explication se termine ici-->

<?php include('partiels/footer.php'); ?>

</body>
</html>

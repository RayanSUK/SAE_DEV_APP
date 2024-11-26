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
<section class="text-center">
    <div class="explication">
        <h1>ICI ON EXPLIQUERA NOTRE SITE !!</h1>
    </div>
</section>

<!-- la section explication se termine ici-->

<?php include('partiels/footer.php'); ?>

</body>
</html>

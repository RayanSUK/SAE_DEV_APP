<?php 
session_start();
ob_start(); // Démarrage du buffer de sortie

include('partiels/navbar.php'); 


// Fonction pour définir le titre de la page
?>

<!-- Section de description -->
<section class="description text-center">
    <div class="titre text-center">
        <h1>Modules de Calculs</h1>
    </div>
</section>

<!-- Formulaire des boutons pour les modules -->
<section class=" text-center">
    <form method="POST">
        <button type="submit" name="loiInverseGaussienne" value="Loi inverse Gaussienne" class="form-button">Loi inverse Gaussienne</button>
        <br><br><br>
    </form>
</section>

<?php 
include('partiels/footer.php'); 

// Gestion des redirections en fonction du module choisi
if (isset($_POST['loiInverseGaussienne'])) {
    header('Location: LoiInverseGaussienne.php');
    ob_end_flush(); // Libérer le buffer après la redirection
}
ob_end_flush(); // Libérer le buffer à la fin du script
?>

</body>
</html>

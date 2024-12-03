<?php 
session_start();
ob_start(); // Démarrage du buffer de sortie

include('partiels/navbar.php'); 


// Fonction pour définir le titre de la page
?>

<!-- Section de description -->
<section class="description text-center">
    <div class="titre text-center">
        <h1>Veuillez cliquer ci-dessous pour utiliser le module de calcul</h1><br><br>
    </div>
</section>

<!-- Formulaire des boutons pour les modules -->
<section class=" text-center">
    <form method="POST">
        <button type="submit" name="loiInverseGaussienne" value="Loi inverse Gaussienne" class="form-button">Loi inverse Gaussienne</button>
        <br><br><br>
    </form>
</section>


<section class="presentation-site">
    <div class="container">
        <h1>📊 Calculs Mathématiques : Loi Inverse Gaussienne</h1>
        <p>
            Découvrez notre module interactif pour explorer la <strong>loi inverse gaussienne</strong>, 
            une distribution clé en mathématiques et statistiques. Cet outil vous permet d'analyser des données 
            et de visualiser vos résultats sous forme de graphiques dynamiques.
        </p>

        <h2>🛠 Comment ça marche ?</h2>
        <ol>
            <li><strong>Entrez vos paramètres :</strong></li>
            <ul>
                <li><strong>x :</strong> La valeur à analyser.</li>
                <li><strong>λ (forme) :</strong> Définit la forme de la distribution.</li>
                <li><strong>μ (espérance) :</strong> Définit la moyenne de la distribution.</li>
            </ul>
            <li><strong>Choisissez une méthode de calcul :</strong></li>
            <ul>
                <li>Rectangles médians</li>
                <li>Rectangles trapèzes</li>
                <li>Méthode de Simpson</li>
            </ul>
            <li><strong>Obtenez vos résultats :</strong></li>
            <ul>
                <li>Visualisez vos données sous forme de <strong>graphiques interactifs</strong> pour mieux comprendre les variations.</li>
            </ul>
        </ol>
    </div>
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

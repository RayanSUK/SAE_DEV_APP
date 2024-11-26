<?php
session_start();
require("fonctionsLIG.php");

// Gestion des erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Loi Inverse Gaussienne</title>
</head>
<body>
    <?php include('partiels/navbar.php'); ?>

<div class="form-container-parent">
    <div class="form-container">
        <h1 class="text-center">Calcul de la Loi Inverse Gaussienne</h1>
        <form method="POST">
    <input type="number" name="x" placeholder="x" class="form-input" required>
    <input type="number" name="forme" placeholder="λ" class="form-input" required>
    <input type="number" name="esperance" placeholder="μ" class="form-input" required>
    
    <!-- Menu déroulant pour choisir une méthode -->
    <select name="methode" class="form-input" required>
        <option value="" disabled selected>Choisissez une méthode</option>
        <option value="rectangles_medians">Méthode des rectangles médians</option>
        <option value="rectangles_trapezes">Méthode des rectangles trapèzes</option>
        <option value="simpson">Méthode de Simpson</option>
    </select>
    
    <!-- Bouton pour valider -->
    <button type="submit" class="form-button">Valider</button>
</form>

    </div>
</div>



<?php
if (isset($_POST['methode']) && isset($_POST['x']) && isset($_POST['forme']) && isset($_POST['esperance'])) {
    $x = $_POST['x'];
    $forme = $_POST['forme'];
    $esperance = $_POST['esperance'];
    $methode = $_POST['methode']; // Méthode choisie

    // Générer les valeurs de x pour le calcul
    $x_values = range(0.1, $x, 0.1); // Évite 0 pour éviter des erreurs de division

    // Effectuer le calcul de la densité (la méthode spécifique pourrait être utilisée ici)
    if ($methode === "rectangles_medians") {
        // Exemple de traitement spécifique pour rectangles médians
        $densities = loi_inverse_gaussienne($x_values, $forme, $esperance);

    // Convertir les données pour le graphique
    $x_values_json = json_encode($x_values);
    $densities_json = json_encode($densities);
?>
    <div class="result-container">
        <h2 class="text-center">Résultats du Calcul - <?= htmlspecialchars($methode) ?></h2>
        <canvas id="myChart" width="400" height="200"></canvas>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var ctx = document.getElementById('myChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: <?= $x_values_json ?>,
                        datasets: [{
                            label: 'Loi Inverse Gaussienne',
                            data: <?= $densities_json ?>,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1,
                            fill: false
                        }]
                    },
                    options: {
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'x'
                                }
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'Densité'
                                }
                            }
                        }
                    }
                });
            });
        </script>
    </div>
<?php
}
}
?>


    <?php include('partiels/footer.php'); ?>
</body>
</html>

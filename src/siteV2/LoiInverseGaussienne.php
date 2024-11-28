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
            <input type="number" name="n" placeholder="n" class="form-input" required>
        <form method="POST" class="text-center">
            <input type="number" name="forme" placeholder="λ" class="form-input" required>
            <input type="number" name="esperance" placeholder="μ" class="form-input" required>
            <input type="number" name="t" placeholder="t" class="form-input" required>



            <!-- Menu déroulant pour choisir une méthode -->
            <select name="methode" class="form-input" required>
                <option value="" disabled selected>Choisissez une méthode</option>
                <option value="rectangles_medians">Méthode des rectangles médians</option>
                <option value="trapezes">Méthode des trapèzes</option>
                <option value="simpson">Méthode de Simpson</option>
            </select>

            <!-- Bouton pour valider -->
            <button type="submit" class="form-buttonS">Valider</button>
        </form>

    </div>
</div>

<?php
if (isset($_POST['methode'], $_POST['n'], $_POST['forme'], $_POST['esperance'], $_POST['t'])) {
    $n = $_POST['n'];
    $forme = $_POST['forme'];
    $esperance = $_POST['esperance'];
    $t = $_POST['t'];
    $methode = $_POST['methode'];

    $points = array();

    $x_values = range(0, $n);


    foreach($x_values as $i => $value){
        $points[] = loi_inverse_gaussienne($value, $esperance, $forme);
    }

    if ($methode == "rectangles_medians") {
        $resultat = methode_rectangles_medians($points, $esperance, $forme, $t);
    }

    if ($methode == "trapezes") {
        $resultat = methode_trapezes($points, $esperance, $forme, $t);
    }

    if($methode == "simpson"){
        $resultat = methode_simpson($points, $esperance, $forme, $t);
    }

    $ecart_type = ecart_type($esperance, $forme);

    echo "<table>";
    echo "<tr>";
    echo "<td>Valeur de probabilité :</td>";
    echo "<td>.$resultat.</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Forme :</td>";
    echo "<td>.$forme.</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Espérance :</td>";
    echo "<td>.$esperance.</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Ecart-type :</td>";
    echo "<td>.$ecart_type.</td>";
    echo "</tr>";




    $x_values_json = json_encode($x_values);
    $points_json = json_encode($points);
        ?>
        <div class="result-container">
            <h2 class="text-center">Courbe de Wald</h2>
            <canvas id="myChart" width="400" height="200"></canvas>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var ctx = document.getElementById('myChart').getContext('2d');
                    var myChart = new Chart(ctx, {
                        data: {
                            labels: <?= $x_values_json ?>,
                            datasets: [
                                {
                                    label: 'Courbe de Wald',
                                    data: <?= $points_json ?>,
                                    type: 'line',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1,
                                    fill: false
                                },
                            ]
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
?>

<?php include('partiels/footer.php'); ?>
</body>
</html>

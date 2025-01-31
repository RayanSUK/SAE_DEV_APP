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

<main role="main">
<div class="form-container-parent">
    <div class="form-container">
        <h1 class="text-center">Calcul de la Loi Inverse Gaussienne</h1>
        <form method="POST">
            <label for="n">Le nombre de valeur prises :</label>
            <input type="number" min="2" name="n" id="n" placeholder="n" class="form-input" required>

            <label for="forme">La forme :</label>
            <input type="number" min="0" name="forme" id="forme" placeholder="λ" class="form-input" required>

            <label for="esperance">L'esperance :</label>
            <input type="number" min="0" name="esperance" id="esperance" placeholder="μ" class="form-input" required>

            <label for="t">La valeur suivant la loi inverse gaussienne :</label>
            <input type="number" min="0" name="t" placeholder="t" id="t" class="form-input" required>



            <!-- Menu déroulant pour choisir une méthode -->
            <form method="POST">
                <label for="methode">Choisissez une méthode :</label>
                <select name="methode" id="methode" class="form-input" required>
                    <option value="" disabled selected>Choisissez une méthode</option>
                    <option value="rectangles_medians">Méthode des rectangles médians</option>
                    <option value="trapezes">Méthode des trapèzes</option>
                    <option value="simpson">Méthode de Simpson</option>
                </select>
            </form>

            <!-- Bouton pour valider -->
            <button type="submit" class="form-buttonS">Valider</button>
        </form>
    </div>
</div>
</main>
<?php
if (isset($_POST['methode'], $_POST['n'], $_POST['forme'], $_POST['esperance'], $_POST['t'])) {
    $n = $_POST['n'];
    $forme = $_POST['forme'];
    $esperance = $_POST['esperance'];
    $t = $_POST['t'];
    $methode = $_POST['methode'];

    $points = array();
    $x_values = range(0, $n);

    foreach ($x_values as $i => $value) {
        $points[] = loi_inverse_gaussienne($value, $esperance, $forme);
    }

    if ($methode == "rectangles_medians") {
        $resultat = methode_rectangles_medians($points, $esperance, $forme, $t);
        echo "<div class='text-center'><img src='images/rectanglesMedians.png' alt=''></div>";
    }

    if ($methode == "trapezes") {
        $resultat = methode_trapezes($points, $esperance, $forme, $t);
        echo "<div class='text-center'><img src='images/methodeTrapezes.png' alt=''></div>";
    }

    if ($methode == "simpson") {
        $resultat = methode_simpson($points, $esperance, $forme, $t);
        echo "<div class='text-center'><img src='images/methodeSimpson.png' alt=''></div>";
    }

    $ecart_type = ecart_type($esperance, $forme);

    echo "<div class='text-center2'>";
    echo "<table>";
    echo "<tr><td>Valeur de probabilité :</td><td>" . $resultat . "</td></tr>";
    echo "<tr><td>Forme :</td><td>" . $forme . "</td></tr>";
    echo "<tr><td>Espérance :</td><td>" . $esperance . "</td></tr>";
    echo "<tr><td>Ecart-type :</td><td>" . $ecart_type . "</td></tr>";
    echo "</table>";

    echo "<form method='POST' action='historique.php'>";  // Redirection vers `historique.php`
    echo "<input type='hidden' name='n' value='" . $n . "'>";
    echo "<input type='hidden' name='forme' value='" . $forme . "'>";
    echo "<input type='hidden' name='esperance' value='" . $esperance . "'>";
    echo "<input type='hidden' name='t' value='" . $t . "'>";
    echo "<input type='hidden' name='methode' value='" . $methode . "'>";
    echo "<input type='hidden' name='resultat' value='" . $resultat . "'>";
    echo "<button type='submit' name='ajouter_history' class='form-buttonS'>Ajouter à l'historique</button>";
    echo "</form>";
    echo "</div>";
   

    $x_values_json = json_encode($x_values);
    $points_json = json_encode($points);
    ?>

    <div class="result-container">
        <h2 class="text-center">Courbe de Wald</h2>
        <canvas id="myChart" width="1000" height="600"></canvas>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var ctx = document.getElementById('myChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    data: {
                        labels: <?= $x_values_json ?>,
                        datasets: [
                            {
                                label: 'Courbe de Wald',
                                data: <?= $points_json ?>,
                                type: 'line',
                                borderColor: 'rgb(55, 66, 250)',
                                borderWidth: 1,
                                fill: true
                            },
                        ]
                    },
                    options: {
                        scales: {
                            x: { title: { display: true, text: 'x' } },
                            y: { title: { display: true, text: 'Densité' } }
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

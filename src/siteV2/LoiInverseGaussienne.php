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
            <input type="number" name="n" placeholder="n" class="form-input" required>
            <input type="number" name="t" placeholder="t" class="form-input" required>
            <input type="number" name="a" placeholder="a" class="form-input" required>
            <input type="number" name="b" placeholder="b" class="form-input" required>


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
if (isset($_POST['methode'], $_POST['x'], $_POST['forme'], $_POST['esperance'], $_POST['n'])) {
    $x = $_POST['x'];
    $forme = $_POST['forme'];
    $esperance = $_POST['esperance'];
    $n = $_POST['n'];
    $methode = $_POST['methode']; // Méthode choisie

    // Générer les valeurs de x pour le calcul
    $x_values = range(0.1, $n, 0.1); // Évite 0 pour éviter des erreurs de division

    // Effectuer le calcul de la densité (la méthode spécifique pourrait être utilisée ici)
    if ($methode === "rectangles_medians") {
        // Exemple de traitement spécifique pour rectangles médians
        $densities = array();
        $rectangles = array();
        $n = count($x_values) - 1;
        $h = ($x - 0.1) / $n;

        foreach($x_values as $i => $value){
            $densities[] = loi_inverse_gaussienne($value, $esperance, $forme);
            if ($i < $n) {
                $x_median = ($value + $x_values[$i + 1]) / 2;
                $rectangles[] = loi_inverse_gaussienne($x_median, $esperance, $forme) * $h;
            }
        }

        // Convertir les données pour le graphique
        $x_values_json = json_encode($x_values);
        $densities_json = json_encode($densities);
        $rectangles_json = json_encode($rectangles);
        ?>
        <div class="result-container">
            <h2 class="text-center">Résultats du Calcul - <?= htmlspecialchars($methode) ?></h2>
            <canvas id="myChart" width="400" height="200"></canvas>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var ctx = document.getElementById('myChart').getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'bar', // Utiliser 'bar' pour les rectangles
                        data: {
                            labels: <?= $x_values_json ?>,
                            datasets: [
                                {
                                    label: 'Loi Inverse Gaussienne',
                                    data: <?= $densities_json ?>,
                                    type: 'line', // Utiliser 'line' pour la courbe de densité
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1,
                                    fill: false
                                },
                                {
                                    label: 'Rectangles Médians',
                                    data: <?= $rectangles_json ?>,
                                    type: 'bar', // Utiliser 'bar' pour les rectangles
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1
                                }
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
}
?>

<?php include('partiels/footer.php'); ?>
</body>
</html>
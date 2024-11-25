<?php
session_start();
require("header_module.php");
require("fonctionsLIG.php");
header_page("Loi inverse Gaussienne");

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "
<form method='POST' class='boutons_tableau_de_bord'>
<input type='number' class='bouton' name='x' placeholder='x'>
<input type='number' class='bouton' name='forme' placeholder='λ'>
<input type='number' class='bouton' name='esperance' placeholder='μ'>
<input type='submit' class='bouton' name='methode1' value='Méthode des rectangles médians'>
<input type='submit' class='bouton' name='methode2' value='Méthode des rectangles trapèzes'>
<input type='submit' class='bouton' name='methode3' value='Méthode de Simpson'>
</form>
";

if (isset($_POST['methode1'], $_POST['x'], $_POST['forme'], $_POST['esperance'])) {
    $x = $_POST['x'];
    $forme = $_POST['forme'];
    $esperance = $_POST['esperance'];

    // Generate a range of x values for the plot
    $x_values = range(0, $x, 0.1);
    $densities = loi_inverse_gaussienne($x_values, $forme, $esperance);
    // Debugging: Print the values to check if they are correct
    echo "<pre>";
    print_r($x_values);
    print_r($densities);
    echo "</pre>";

    // Encode the data as JSON
    $x_values_json = json_encode($x_values);
    $densities_json = json_encode($densities);

    echo "
    <canvas id='myChart' width='400' height='200'></canvas>
    <script src='https://cdn.jsdelivr.net/npm/chart.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Debugging: Print the values to check if they are correct
            console.log($x_values_json);
            console.log($densities_json);

            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: $x_values_json,
                    datasets: [{
                        label: 'Loi inverse Gaussienne',
                        data: $densities_json,
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
    ";
}

?>

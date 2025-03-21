<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

include('partiels/navbar.php');
include('fonctionsPolynome.php');

// Connexion à la base de données
$cnx = mysqli_connect("localhost", "root", "root", "sigmax");
if (!$cnx) {
    die("Échec de la connexion à la base de données: " . mysqli_connect_error());
}

// Requête d'insertion avec jointure
$query = "
SELECT methode, n, forme, esperance, t, resultat, date, id
FROM history
WHERE login = ?;
";

$stmt = mysqli_prepare($cnx, $query);
mysqli_stmt_bind_param($stmt, "s", $_SESSION['login']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$query2 = "
SELECT a, b, c, delta, date, id
FROM polynomial
WHERE login = ?;
";

$stmt2 = mysqli_prepare($cnx, $query2);
mysqli_stmt_bind_param($stmt2, "s", $_SESSION['login']);
mysqli_stmt_execute($stmt2);
$result2 = mysqli_stmt_get_result($stmt2);
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    
    <title>Historique des Résultats</title>
    

    <style>
        /* Styles pour centrer le tableau */
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        .container {
            width: 85%;
            margin: 0 auto; /* Centrer le container */
        }
        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse; /* Pour avoir des bordures sans espace */
            text-align: left;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .invisible {
            display: none;
        }
    </style>
    <!-- Inclusion de Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<role="main">

    <br><br>
    <div class="container">
        <h1>Historique (Module Probabilités)</h1>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <table>
                <thead>
                <tr>
                    <th>Méthode</th>
                    <th>n</th>
                    <th>Forme</th>
                    <th>Espérance</th>
                    <th>t</th>
                    <th>Résultat</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr id="row-<?php echo htmlspecialchars($row['id']); ?>">
                        <td><?php echo htmlspecialchars($row['methode']); ?></td>
                        <td><?php echo htmlspecialchars($row['n']); ?></td>
                        <td><?php echo htmlspecialchars($row['forme']); ?></td>
                        <td><?php echo htmlspecialchars($row['esperance']); ?></td>
                        <td><?php echo htmlspecialchars($row['t']); ?></td>
                        <td><?php echo htmlspecialchars($row['resultat']); ?></td>
                        <td><?php echo htmlspecialchars($row['date']); ?></td>
                        <td>
                            <form method="post" action="">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                <button type='submit' name='courbe' class='form-buttonS'>Consulter la courbe</button>
                                <button type='submit' name='supp' class='form-buttonS delete-button' data-id="<?php echo htmlspecialchars($row['id']); ?>">Supprimer de l'historique</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucun résultat trouvé.</p>
        <?php endif; ?>
    </div>

    <br><br><br>
    <div class="container">
        <h1>Historique (Module Polynômes)</h1>
        <?php if (mysqli_num_rows($result2) > 0): ?>
            <table>
                <thead>
                <tr>
                    <th>a</th>
                    <th>b</th>
                    <th>c</th>
                    <th>Δ (Discriminant)</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($row = mysqli_fetch_assoc($result2)): ?>
                    <tr id="row-<?php echo htmlspecialchars($row['id']); ?>">
                        <td><?php echo htmlspecialchars($row['a']); ?></td>
                        <td><?php echo htmlspecialchars($row['b']); ?></td>
                        <td><?php echo htmlspecialchars($row['c']); ?></td>
                        <td><?php echo htmlspecialchars($row['delta']); ?></td>
                        <td><?php echo htmlspecialchars($row['date']); ?></td>
                        <td>
                            <form method="post" action="">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                <button type='submit' name='polynome' class='form-buttonS'>Afficher les résultats</button>
                                <button type='submit' name='supp2' class='form-buttonS delete-button' data-id="<?php echo htmlspecialchars($row['id']); ?>">Supprimer de l'historique</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucun résultat trouvé.</p>
        <?php endif; ?>
    </div>

    
</main>

<?php
require("fonctionsLIG.php");


//affichage des résultats avec MathJax pour une meilleure mise en forme
if (isset($_POST['polynome']) && isset($_POST['id'])) {
    $id = $_POST['id'];
    $query = "SELECT a, b, c, delta FROM polynomial WHERE id = ?";
    $stmt = mysqli_prepare($cnx, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $a = $row['a'];
        $b = $row['b'];
        $c = $row['c'];
        $delta = $row['delta'];

        // Calcul des racines selon le discriminant
        // On assure que le signe devant les termes est correctement géré pour éviter les doubles signes négatifs
        $bAffiche = ($b < 0) ? "(" . $b . ")" : $b; // Si b est négatif, on l'encadre entre parenthèses
        $aAffiche = ($a < 0) ? "(" . $a . ")" : $a; // Si a est négatif, on l'encadre entre parenthèses
        if ($delta > 0) {
            $solution1 = racineReelle1($a, $b, $c);
            $solution2 = racineReelle2($a, $b, $c);
            // Format LaTeX pour afficher sous forme de fraction
            echo "<div class='math-equation'>\\[ x_{1} = \\frac{- $bAffiche-\\sqrt{$delta}}{2 \\times $aAffiche} = " . htmlspecialchars($solution1) . " \\] ou \\[ x_{2} = \\frac{- $bAffiche+\\sqrt{$delta}}{2 \\times $aAffiche} = " . htmlspecialchars($solution2) . " \\]</div>";
        } elseif ($delta == 0) {
            $racineUnique = racineUnique($a, $b);
            // Format LaTeX pour la racine unique
            echo "<div class='math-equation'>\\[x = \\frac{- $bAffiche}{2 \\times $aAffiche} = " . htmlspecialchars($racineUnique) . " \\]</div>";
        } else {
            $racineComplexe1 = racineComplexe1($a, $b, $c);
            $racineComplexe2 = racineComplexe2($a, $b, $c);
            $reelle1 = $racineComplexe1[0];
            $imaginaire1 = $racineComplexe1[1];
            $reelle2 = $racineComplexe2[0];
            $imaginaire2 = $racineComplexe2[1];

           
            // Si delta est négatif, on le multiplie par -1 pour le rendre positif dans la racine carrée
            $deltaAffiche = ($delta < 0) ? -$delta : $delta;
            
            
            echo "<div class='math-equation'>Parties réelles : \\[ x_{1} = \\frac{- $bAffiche - i\\sqrt{$deltaAffiche}}{2 \\times $aAffiche} = " . htmlspecialchars($reelle1) . " \\] ou \\[ x_{2} = \\frac{- $bAffiche + i\\sqrt{$deltaAffiche}}{2 \\times $aAffiche} = " . htmlspecialchars($reelle2) . " \\]</div>";
            
            echo "<div class='math-equation'>Parties imaginaires : \\[ x_{1} = \\frac{- $bAffiche - i\\sqrt{$deltaAffiche}}{2 \\times $aAffiche} = " . htmlspecialchars($imaginaire1) . " \\] ou \\[ x_{2} = \\frac{- $bAffiche + i\\sqrt{$deltaAffiche}}{2 \\times $aAffiche} = " . htmlspecialchars($imaginaire2) . " \\]</div>";
    
        }
    }
}
?>
<script>
    MathJax.typeset(); // Pour rendre les expressions MathJax après leur ajout dans le DOM
</script>


<?php
if(isset($_POST['supp']) && isset($_POST['id'])){
    $id = $_POST['id'];
    $query = "DELETE FROM history WHERE id = ?";
    $stmt = mysqli_prepare($cnx, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    echo "<p id='success-message' style='color: rgb(55, 66, 250)'>Données supprimées avec succès, veuillez rafraîchir la page<br></p>";
}
?>

<?php
if(isset($_POST['supp2']) && isset($_POST['id'])){
    $id = $_POST['id'];
    $query = "DELETE FROM polynomial WHERE id = ?";
    $stmt = mysqli_prepare($cnx, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    echo "<p id='success-message' style='color: rgb(55, 66, 250)'>Données supprimées avec succès, veuillez rafraîchir la page <br></p>";
}
?>

<?php
if (isset($_POST['courbe']) && isset($_POST['id'])) {
    $id = $_POST['id'];
    $t = 0;
    $query = "SELECT n, esperance, forme, t FROM history WHERE id = ?";
    $stmt = mysqli_prepare($cnx, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $t = $row['t'];
        $points = array();
        $x_values = range(0, $row['n']);
        foreach ($x_values as $i => $value) {
            $points[] = loi_inverse_gaussienne($value, $row['esperance'], $row['forme']);
        }

        $t_json = json_encode($t);
        $x_values_json = json_encode($x_values);
        $points_json = json_encode($points);
    } else {
        echo "<p>Aucune donnée trouvée pour générer la courbe.</p>";
    }
}
?>

<?php if (isset($x_values_json) && isset($points_json)): ?>
    <div class='result-container'>
        <h2 class='text-center'>Courbe de Wald</h2>
        <canvas id='myChart' width='1000' height='600'></canvas>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var ctx = document.getElementById('myChart').getContext('2d');

                // Ensure that PHP variables are correctly embedded in JavaScript
                var xValues = <?= $x_values_json ?>;
                var points = <?= $points_json ?>;
                var t = <?= $t_json ?>;

                // Use xValues directly without rounding
                var pointsY = points; // Assuming pointsY is the same as points

                var myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: xValues,
                        datasets: [
                            {
                                label: 'Courbe de Wald',
                                data: points,
                                borderColor: 'rgb(55, 66, 250)',
                                backgroundColor: 'rgba(55, 66, 250, 0.2)',
                                borderWidth: 2,
                                fill: false,
                                tension: 0.4,
                                pointRadius: 0,
                                pointHoverRadius: 0,
                            },
                            {
                                label: 'Aire sous la courbe P(X ≤ t)',
                                data: xValues.map((x, index) => {
                                    return x <= t ? pointsY[index] : null;
                                }),
                                backgroundColor: 'rgba(55, 66, 250, 0.2)',
                                borderWidth: 0,
                                fill: true,
                            }
                        ]
                    },
                    options: {
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top'
                            }
                        },
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



  


<?php endif; ?>


<?php include('partiels/footer.php'); ?>


<script>
    //Ce script permet de charger directement la page sur l'affichage du résultat, évite de scroller
    document.addEventListener("DOMContentLoaded", function () {
        // Vérifie si un résultat ou une courbe a été affiché
        let results = document.querySelector(".math-equation");
        let chart = document.getElementById("myChart");

        if (results || chart) {
            // Fait défiler vers le bas de la page
            window.scrollTo({ top: document.body.scrollHeight, behavior: "smooth" });
        }
    });
</script>


</body>
</html>

<?php
// Fermeture de la connexion
mysqli_free_result($result);
mysqli_stmt_close($stmt);
mysqli_close($cnx);
?>

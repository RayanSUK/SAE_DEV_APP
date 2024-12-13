<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

include('partiels/navbar.php');

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
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des Résultats</title>
    <style>
        /* Styles pour centrer le tableau */
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        .container {
            width: 80%;
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
        }
        th {
            background-color: #f4f4f4;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
    <!-- Inclusion de Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="container">
    <h2>Historique des Résultats</h2>
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
                <th>Date</th> <!-- Nouvelle colonne pour la date -->
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['methode']); ?></td>
                    <td><?php echo htmlspecialchars($row['n']); ?></td>
                    <td><?php echo htmlspecialchars($row['forme']); ?></td>
                    <td><?php echo htmlspecialchars($row['esperance']); ?></td>
                    <td><?php echo htmlspecialchars($row['t']); ?></td>
                    <td><?php echo htmlspecialchars($row['resultat']); ?></td>
                    <td><?php echo htmlspecialchars($row['date']); ?></td> <!-- Affichage de la date -->
                    <td>
                        <form method="post" action="">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                            <button type='submit' name='courbe' class='form-buttonS'>Consulter la courbe</button>
                            <button type='submit' name='supp' class='form-buttonS'>Supprimer de l'historique</button>
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

<?php
require("fonctionsLIG.php");

if(isset($_POST['supp']) && isset($_POST['id'])){
    $id = $_POST['id'];
    $query = "DELETE FROM history WHERE id = ?";
    $stmt = mysqli_prepare($cnx, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
}

if (isset($_POST['courbe']) && isset($_POST['id'])) {
    $id = $_POST['id'];
    $query = "SELECT n, esperance, forme FROM history WHERE id = ?";
    $stmt = mysqli_prepare($cnx, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $points = array();
        $x_values = range(0, $row['n']);
        foreach ($x_values as $i => $value) {
            $points[] = loi_inverse_gaussienne($value, $row['esperance'], $row['forme']);
        }

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
                var myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: <?= $x_values_json ?>,
                        datasets: [
                            {
                                label: 'Courbe de Wald',
                                data: <?= $points_json ?>,
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
<?php endif; ?>

</body>
</html>

<?php
// Fermeture de la connexion
mysqli_free_result($result);
mysqli_stmt_close($stmt);
mysqli_close($cnx);
?>

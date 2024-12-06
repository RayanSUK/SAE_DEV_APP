<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: accueil_non_inscrit.php");
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
SELECT methode, n, forme, esperance, t, resultat, date
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
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucun résultat trouvé.</p>
        <?php endif; ?>
    </div>

</body>
</html>

<?php
// Fermeture de la connexion
mysqli_free_result($result);
mysqli_stmt_close($stmt);
mysqli_close($cnx);
?>

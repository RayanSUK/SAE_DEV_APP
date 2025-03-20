<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}
require('fonctionsPolynome.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    <title>Polynômes</title>
</head>
<?php
include('partiels/navbar.php');
?>

<main role="main">
    <!-- description section starts here -->
    <section class="description text-center">
        <div class="titre text-center">
            <h1>Module polynôme</h1>
        </div>
    </section>
</main>

<section class="presentation-site">
<div class="container">
    <h1>🔢 Module de Polynôme </h1>
    <p>
        Découvrez notre module interactif dédié à la résolution d'une équation du second degré sous la forme <strong>ax² + bx + c = 0</strong>. Ce module vous aide à calculer les solutions en fonction du discriminant.
    </p>

    <h2>🛠 Comment ça marche ?</h2>
    <ol>
        <li><strong>Entrez vos paramètres :</strong></li>
        <ul>
            <li><strong>a :</strong> Le coefficient de x².</li>
            <li><strong>b :</strong> Le coefficient de x.</li>
            <li><strong>c :</strong> Le terme constant.</li>
        </ul>
        <li><strong>Lancez l'opération :</strong></li>
        <ul>
            <li>Le discriminant \(\Delta = b² - 4ac\) est calculé.</li>
            <li>Selon la valeur de \(\Delta\), vous obtiendrez soit deux solutions réelles distinctes, une seule solution réelle, ou deux solutions complexes.</li>
        </ul>
        <li><strong>Obtenez vos résultats :</strong></li>
        <ul>
            <li>Les solutions réelles ou complexes sont affichées avec la formule mathématique.</li>
        </ul>
    </ol>
</div>
</section>

<main role="main">
    <div class="form-container-parent">
        <div class="form-container" id="polynomial-form">
            <h1 class="text-center">Calcul d'un polynôme de second degré</h1>
            <form method="POST">
                <label for="a">a : </label>
                <input type="number" name="a" id="a" placeholder="a" class="form-input" step="0.01" required>

                <label for="b">b : </label>
                <input type="number" name="b" id="b" placeholder="b" class="form-input" step="0.01" required>

                <label for="c">c : </label>
                <input type="number" name="c" id="c" placeholder="c" class="form-input" step="0.01" required>

                <button type="submit" class="form-buttonS">Valider</button>
            </form>
        </div>
    </div>
</main>

<?php
if (isset($_POST['a'], $_POST['b'], $_POST['c'])) {
    $a = $_POST['a'];
    $b = $_POST['b'];
    $c = $_POST['c'];
    $delta = discriminant($a, $b, $c);

    echo "<div class='result-container'>"; // Conteneur principal des résultats

    // Cas discriminant = 0 (racine unique)
    if ($delta == 0) {
        $solution = racineUnique($a, $b);

        echo "<div class='result-box'>";
        echo "<h2>\(\Delta\) = 0 (racine unique)</h2>";
        echo "<table>";
        echo "<tr><th>Solution :</th><td>" . htmlspecialchars($solution) . "</td></tr>";
        echo "<tr><th>Discriminant :</th><td>" . htmlspecialchars($delta) . "</td></tr>";
        echo "<tr><th>a :</th><td>" . htmlspecialchars($a) . "</td></tr>";
        echo "<tr><th>b :</th><td>" . htmlspecialchars($b) . "</td></tr>";
        echo "<tr><th>c :</th><td>" . htmlspecialchars($c) . "</td></tr>";
        echo "</table>";
        echo "</div>";

        echo "<div class='math-equation'>\\[x = -\\frac{$b}{2 \\times $a} = " . htmlspecialchars($solution) . " \\]</div>";
    }

    // Cas discriminant > 0 (deux racines réelles distinctes)
    else if ($delta > 0) {
        $solution1 = racineReelle1($a, $b, $c);
        $solution2 = racineReelle2($a, $b, $c);

        echo "<div class='result-box'>";
        echo "<h2>\(\Delta\) > 0 (deux racines réelles)</h2>";
        echo "<table>";
        echo "<tr><th>Solution 1 :</th><td>" . htmlspecialchars($solution1) . "</td></tr>";
        echo "<tr><th>Solution 2 :</th><td>" . htmlspecialchars($solution2) . "</td></tr>";
        echo "<tr><th>Discriminant :</th><td>" . htmlspecialchars($delta) . "</td></tr>";
        echo "<tr><th>a :</th><td>" . htmlspecialchars($a) . "</td></tr>";
        echo "<tr><th>b :</th><td>" . htmlspecialchars($b) . "</td></tr>";
        echo "<tr><th>c :</th><td>" . htmlspecialchars($c) . "</td></tr>";
        echo "</table>";
        echo "</div>";

        echo "<div class='math-equation'>\\[ x_{1} = -\\frac{ $b-\\sqrt{$delta}}{2 \\times $a} = " . htmlspecialchars($solution1) . " \\] ou \\[ x_{2} = -\\frac{ $b+\\sqrt{$delta}}{2 \\times $a} = " . htmlspecialchars($solution2) . " \\]</div>";
    }

    // Cas discriminant < 0 (solutions complexes)
    else if ($delta < 0) {
        $delta *= -1;
        $solution1 = racineComplexe1($a, $b, $c);
        $reelle1 = $solution1[0];
        $imaginaire1 = $solution1[1];

        $solution2 = racineComplexe2($a, $b, $c);
        $reelle2 = $solution2[0];
        $imaginaire2 = $solution2[1];

        echo "<div class='result-box'>";
        echo "<h2>\(\Delta\) < 0 (solutions complexes)</h2>";
        echo "<table>";
        echo "<tr><th>Solution 1 (partie réelle) :</th><td>" . htmlspecialchars($reelle1) . "</td></tr>";
        echo "<tr><th>Solution 1 (partie imaginaire) :</th><td>" . htmlspecialchars($imaginaire1) . "</td></tr>";
        echo "<tr><th>Solution 2 (partie réelle) :</th><td>" . htmlspecialchars($reelle2) . "</td></tr>";
        echo "<tr><th>Solution 2 (partie imaginaire) :</th><td>" . htmlspecialchars($imaginaire2) . "</td></tr>";
        echo "<tr><th>Discriminant :</th><td>" . htmlspecialchars($delta) . "</td></tr>";
        echo "<tr><th>a :</th><td>" . htmlspecialchars($a) . "</td></tr>";
        echo "<tr><th>b :</th><td>" . htmlspecialchars($b) . "</td></tr>";
        echo "<tr><th>c :</th><td>" . htmlspecialchars($c) . "</td></tr>";
        echo "</table>";
        echo "</div>";

        echo "<div class='math-equation'>Parties réelles : \\[ x_{1} = -\\frac{ $b - i\\sqrt{$delta}}{2 \\times $a} = " . htmlspecialchars($reelle1) . " \\] ou \\[ x_{2} = -\\frac{ $b + i\\sqrt{$delta}}{2 \\times $a} = " . htmlspecialchars($reelle2) . " \\]</div>";
        echo "<div class='math-equation'>Parties imaginaires : \\[ x_{1} = -\\frac{ $b - i\\sqrt{$delta}}{2 \\times $a} = " . htmlspecialchars($imaginaire1) . " \\] ou \\[ x_{2} = -\\frac{ $b + i\\sqrt{$delta}}{2 \\times $a} = " . htmlspecialchars($imaginaire2) . " \\]</div>";
    }

    echo "</div>"; // Fin du conteneur des résultats
}
?>


<?php include('partiels/footer.php'); ?>

</body>
</html>

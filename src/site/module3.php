<?php 
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}
require('fonctionsPolynome.php');
include('partiels/navbar.php') 
?>


<main role="main">
<!-- description section starts here -->
<section class="description text-center">
    <div class="titre text-center">
        <h1>Module 3</h1>
    </div>

 </section>
</main>

<main role="main">
    <div class="form-container-parent">
        <div class="form-container">
            <h1 class="text-center">Calcul d'un polynôme de second degré</h1>
            <form method="POST">
                <label for="n">a : </label>
                <input type="number" name="n" id="n" placeholder="a" class="form-input" required>

                <label for="forme">b : </label>
                <input type="number" name="b" id="b" placeholder="b" class="form-input" required>

                <label for="forme">c : </label>
                <input type="number" name="c" id="c" placeholder="c" class="form-input" required>
                <button type="submit" class="form-buttonS">Valider</button>
            </form>
        </div>
    </div>
</main>
<?php
if(isset($_POST['a'], $_POST['b'], $_POST['c'])){
    $a = $_POST['a'];
    $b = $_POST['b'];
    $c = $_POST['c'];
    $delta = discriminant($a, $b, $c);

    if($delta == 0){
        $solution = racineUnique($a,$b);

        echo "<div class='text-center2'>";
        echo "<table>";
        echo "<caption>Résultats statistiques</caption>";
        echo "<tbody>";
        echo "<tr><th>Solution :</th><td>" . $solution . "</td></tr>";
        echo "<tr><th>Discriminant :</th><td>" . $delta . "</td></tr>";
        echo "<tr><th>a :</th><td>" . $a . "</td></tr>";
        echo "<tr><th>b :</th><td>" . $b . "</td></tr>";
        echo "<tr><th>c :</th><td>" . $c . "</td></tr>";
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
    } else if($delta > 0){
        $solution1 = racineReelle1($a,$b,$c);
        $solution2 = racineReelle2($a,$b,$c);

        echo "<div class='text-center2'>";
        echo "<table>";
        echo "<caption>Résultats statistiques</caption>";
        echo "<tbody>";
        echo "<tr><th>Solution 1 :</th><td>" . $solution1 . "</td></tr>";
        echo "<tr><th>Solution 2 :</th><td>" . $solution2 . "</td></tr>";
        echo "<tr><th>Discriminant :</th><td>" . $delta . "</td></tr>";
        echo "<tr><th>a :</th><td>" . $a . "</td></tr>";
        echo "<tr><th>b :</th><td>" . $b . "</td></tr>";
        echo "<tr><th>c :</th><td>" . $c . "</td></tr>";
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
    } else if($delta < 0){
        $solution1 = racineComplexe1($a,$b,$c);
        $solution2 = racineComplexe2($a,$b,$c);

        echo "<div class='text-center2'>";
        echo "<table>";
        echo "<caption>Résultats statistiques</caption>";
        echo "<tbody>";
        echo "<tr><th>Solution 1 partie réelle :</th><td>" . $solution1[0] . "</td></tr>";
        echo "<tr><th>Solution 1 partie imaginaire :</th><td>" . $solution1[1] . "</td></tr>";
        echo "<tr><th>Solution 2 partie réelle :</th><td>" . $solution2[0] . "</td></tr>";
        echo "<tr><th>Solution 2 partie imaginaire :</th><td>" . $solution2[1] . "</td></tr>";
        echo "<tr><th>Discriminant :</th><td>" . $delta . "</td></tr>";
        echo "<tr><th>a :</th><td>" . $a . "</td></tr>";
        echo "<tr><th>b :</th><td>" . $b . "</td></tr>";
        echo "<tr><th>c :</th><td>" . $c . "</td></tr>";
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
    }
}
?>


 <?php include('partiels/footer.php') ?>



    
</body>  
</html>

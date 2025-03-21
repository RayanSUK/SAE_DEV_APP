<?php
session_start();

require("fonctionsPolynome.php");

// Gestion des erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['ajouter_history'])) {
    // Récupérer les données du formulaire
    $a = $_POST['a'];
    $b = $_POST['b'];
    $c = $_POST['c'];
    $delta = discriminant($a,$b,$c);
    $solutionUnique = "--";
    $solutionReelle1 = "--";
    $solutionReelle2 = "--";
    $solutionComplexe1 = "--";
    $solutionComplexe2 = "--";
    $login = $_SESSION['login']; // Assurez-vous que l'utilisateur est connecté

    // Connexion à la base de données
    $cnx = mysqli_connect("localhost", "root", "root", "sigmax");
    if (!$cnx) {
        die("Échec de la connexion à la base de données : " . mysqli_connect_error());
    }

    if ($delta == 0) {
        $solutionUnique = racineUnique($a, $b);
    } elseif ($delta > 0) {
        $solutionReelle1 = racineReelle1($a, $b, $c);
        $solutionReelle2 = racineReelle2($a, $b, $c);
    } else {
        $partieReelle = -$b / (2 * $a);
        $partieImaginaire = sqrt(-discriminant($a, $b, $c)) / (2 * $a);
        $solutionComplexe1 = "$partieReelle - {$partieImaginaire}i";
        $solutionComplexe2 = "$partieReelle + {$partieImaginaire}i";
    }


    // Insertion des résultats dans la table `polynomial`
    $requete = "
        INSERT INTO polynomial (login, a, b, c, delta, `unique`, reel1, reel2, comp1, comp2, id_user, date)
        SELECT ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, u.id, NOW()
        FROM users u
        WHERE u.login = ?;
    ";


    if ($stmt = mysqli_prepare($cnx, $requete)) {
        // Lier les paramètres
        mysqli_stmt_bind_param($stmt, "siiiissssss", $login, $a, $b, $c, $delta, $solutionUnique, $solutionReelle1, $solutionReelle2, $solutionComplexe1, $solutionComplexe2, $login);
        // Exécution de la requête
        if (mysqli_stmt_execute($stmt)) {
            echo "Données ajoutées à l'historique avec succès.";
            header("location: history.php");
        } else {
            echo "Erreur lors de l'ajout des données : " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Erreur dans la préparation de la requête : " . mysqli_error($cnx);
    }

    // Fermeture de la connexion
    mysqli_close($cnx);
}
?>





<?php
session_start();

// Gestion des erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['ajouter_history'])) {
    // Récupérer les données du formulaire
    $n = $_POST['n'];
    $forme = $_POST['forme'];
    $esperance = $_POST['esperance'];
    $t = $_POST['t'];
    $methode = $_POST['methode'];
    $resultat = $_POST['resultat'];
    $nom = $_SESSION['login']; // Assurez-vous que l'utilisateur est connecté

    // Connexion à la base de données
    $cnx = mysqli_connect("localhost", "root", "root", "sigmax");
    if (!$cnx) {
        die("Échec de la connexion à la base de données : " . mysqli_connect_error());
    }

    // Requête d'insertion avec jointure pour inclure la date
    $requete = "
        INSERT INTO history (login, methode, n, forme, esperance, t, resultat, id_user, date)
        SELECT ?, ?, ?, ?, ?, ?, ?, u.id, NOW()
        FROM users u
        WHERE u.login = ?;
    ";

    if ($stmt = mysqli_prepare($cnx, $requete)) {
        // Lier les paramètres
        mysqli_stmt_bind_param($stmt, "ssssddss", $nom, $methode, $n, $forme, $esperance, $t, $resultat, $nom);
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





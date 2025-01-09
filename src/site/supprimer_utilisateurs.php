<?php
// Démarrer la session pour pouvoir utiliser les variables de session
session_start();

// Connexion à la base de données
$cnx = mysqli_connect('localhost', 'root', 'root', 'sigmax');

// Vérification de la connexion
if (!$cnx) {
    die("Échec de connexion à la base de données : " . mysqli_connect_error());
}

// Récupérer le login depuis le formulaire
$login = mysqli_real_escape_string($cnx, $_POST['login']);
$message = ""; // Initialiser une variable pour le message

// Vérifier quel bouton a été cliqué
if (isset($_POST['delete_user'])) {
    // Supprimer l'utilisateur de la base de données
    $query = "DELETE FROM users WHERE login = '$login'";
    if (mysqli_query($cnx, $query)) {
        $message = "Utilisateur '$login' supprimé avec succès de la base de données.";

        // Enregistrer l'action de suppression dans un fichier log
        $log_message = "[" . date('Y-m-d H:i:s') . "] Utilisateur '$login' supprimé de la base de données.\n";
        file_put_contents('log_suppressions.txt', $log_message, FILE_APPEND);
    } else {
        $message = "Erreur lors de la suppression de '$login' : " . mysqli_error($cnx);
    }
} elseif (isset($_POST['delete_history'])) {
    // 1. Supprimer l'historique de l'utilisateur dans la table `history`
    $query = "DELETE FROM history WHERE login = '$login'";
    if (mysqli_query($cnx, $query)) {
        $message = "Historique de l'utilisateur '$login' supprimé de la base de données.";

        // Enregistrer l'action de suppression dans un fichier log
        $log_message = "[" . date('Y-m-d H:i:s') . "] Historique de l'utilisateur '$login' supprimé de la base de données.\n";
        file_put_contents('log_suppressions.txt', $log_message, FILE_APPEND);
    } else {
        $message = "Erreur lors de la suppression de l'historique de '$login' : " . mysqli_error($cnx);
    }
}

// Enregistrer le message dans la session
$_SESSION['message'] = $message;

// Fermeture de la connexion à la base de données
mysqli_close($cnx);

// Rediriger vers la page de gestion des utilisateurs
header("Location: inscritcsv2.php");
exit();
?>

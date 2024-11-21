<?php
ob_start(); // Start output buffering

require('header_inscription.php');
header_page("Connexion");

echo "<fieldset class='formulaire_inscription'><legend>Inscription</legend>
        <form class='formulaire_inscription' method='POST'>
        <input type='text' name='nom' placeholder='Pseudo'>
        <input type='password' name='mdp' placeholder='Mot de passe'>
        <input type='submit' name='acces' value='Accéder au tableau de bord'>";

if (isset($_POST['nom'], $_POST['mdp'], $_POST['acces'])) {
    $nom = $_POST['nom'];
    $mdp = $_POST['mdp'];

    // Open the file in append mode
    $fp = fopen('utilisateurs.csv', 'r');

    while ($row = fgetcsv($fp, 1024, ",")) {
        $stored_nom = $row[0];
        $stored_mdp = $row[1];
        if ($nom == $stored_nom && $mdp == $stored_mdp) {
            // If they match, credentials are correct, redirect to the dashboard
            header('Location: tableau_de_bord.php');
            ob_end_flush(); // Flush the output buffer
            exit;  // Make sure to call exit() after the header to stop further code execution
        }
    }
    fclose($fp);
    echo "<p style='background-color: red'>Identifiants incorrects</p>";
}

ob_end_flush(); // Flush the output buffer at the end of the script
?>

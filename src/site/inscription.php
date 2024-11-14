<?php
require('header_inscription.php');
header_page("Inscription");

$tab = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);
shuffle($tab);
$nb = rand(0, count($tab) - 1);

echo "<fieldset class='formulaire_inscription'><legend>Inscription</legend>
        <form class='formulaire_inscription' method='POST'>
        <input type='text' name='nom' placeholder='Pseudo'>
        <input type='password' name='mdp' placeholder='Mot de passe'>";

// Table with shuffled numbers, highlighting the correct one
echo "<table><tr>";
foreach ($tab as $value) {
    // Highlight the correct answer in red
    if ($value == $nb) {
        echo "<td><input type='submit' name='reponse' value='$value' style='background-color: red' required></td>";
    } else {
        echo "<td><input type='submit' name='reponse' value='$value'></td>";
    }
}
echo "</tr></table>";

if (isset($_POST['nom'], $_POST['mdp'], $_POST['reponse'])) {
    $nom = $_POST['nom'];
    $mdp = $_POST['mdp'];
    $reponse = $_POST['reponse'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $date = date("Y-m-d H:i:s");

    // Open the file in append mode
    $fp = fopen('utilisateurs.csv', 'a');

    // Write data to the file
    fwrite($fp, "\n$nom,$mdp,$reponse,$ip,$date,");

    // Close the file
    fclose($fp);
}
?>

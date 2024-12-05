<?php
session_start();
session_destroy(); // Détruit toutes les données de session
header("Location: accueil_non_inscrit.php"); // Redirige vers la page d'accueil pour les visiteurs
exit;
?>

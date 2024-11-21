<?php
function header_page($titre)
{
    echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>$titre</title>
    <link rel='stylesheet' href='styles.css'></head>
<body>
<header>
<h1 class='titre'>SigmaX</h1>
<form method='post' class='boutons'>
<input type='submit' class='bouton' name='logout' value='Logout'>
</form>
</header>
<body>";
}

if (isset($_POST['logout'])) {
    header("Location: connexion.php");
}



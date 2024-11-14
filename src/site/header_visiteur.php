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
<form class='boutons_co_et_inscription' method='post'>
    <input class='bouton_login' name='connexion' type='submit' value='Connexion'>
    <input class='bouton_signin' name='inscription' type='submit' value='Inscription'>
</form>
</header>
<body>";
}

if(isset($_POST['inscription'])){
    header('Location: inscription.php');
}
if(isset($_POST['connexion'])){
    header('Location: connexion.php');
}



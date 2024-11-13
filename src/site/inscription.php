<?php
require('header_inscription.php');
header_page("Inscription");

echo "<fieldset><legend>Inscription</legend>
        <form method='POST'>
        <input type='text' name='nom' placeholder='Pseudo'>
        <input type='password' name='mdp' placeholder='Mot de passe'>
        </form>
";

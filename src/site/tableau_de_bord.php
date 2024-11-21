<?php
session_start();
ob_start();
require("header_utilisateur.php");
header_page("Modules de calculs");

echo "
<form method='POST' class='boutons_tableau_de_bord'>
<input type='submit' class='bouton' name='loiInverseGaussienne' value='Loi inverse Gaussienne'>
<input type='submit' class='bouton' name='' value='?'>
<input type='submit' class='bouton' name='' value='?'>
<input type='submit' class='bouton' name='' value='?'>
</form>
</body>";

if (isset($_POST['loiInverseGaussienne'])) {
    header('Location: LoiInverseGaussienne.php');
    ob_end_flush(); // Flush the output buffer
}

ob_end_flush(); // Flush the output buffer

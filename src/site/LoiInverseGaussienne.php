<?php
session_start();
require("header_module.php");
header_page("Loi inverse Gaussienne");
echo "
<form method='POST' class='boutons_tableau_de_bord'>
<input type='number' class='bouton' name='x' placeholder='x'>
<input type='number' class='bouton' name='x' placeholder='λ'>
<input type='number' class='bouton' name='x' placeholder='μ'>
<input type='submit' class='bouton' name='methode1' value='Méthode des rectangles gauches'>
<input type='submit' class='bouton' name='methode2' value='Méthode des rectangles droits'>
<input type='submit' class='bouton' name='methode3' value='Méthode des rectangles médians'>
<input type='submit' class='bouton' name='methode4' value='Méthode des rectangles trapèzes'>
<input type='submit' class='bouton' name='methode5' value='Méthode de Simpson'>
</form>
</body>";


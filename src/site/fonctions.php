<?php
function Captcha() {
    // Générer deux nombres aléatoires
    $num1 = rand(0, 9);
    $num2 = rand(0, 9);

    // Stocker le résultat attendu dans la session
    $_SESSION['captcha'] = $num1 + $num2;

    // Retourner l'affichage de l'addition
    return [$num1, $num2];
}
?>

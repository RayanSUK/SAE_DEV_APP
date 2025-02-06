<?php
function loi_inverse_gaussienne($x, $esperance, $forme) {
    if ($x <= 0) {
        return 0;
    } else {
        return sqrt($forme / (2 * pi() * pow($x, 3))) * exp(-($forme * pow($x - $esperance, 2)) / (2 * pow($esperance, 2) * $x));
    }
}

function methode_rectangles_medians($points, $esperance, $forme, $t) {
    $resultat = 0;
    $n = count($points) - 1;
    $largeur = $points[$t-1] / $n;

    for ($i = 0; $i < $n; $i++) {
        $m = ($points[$i] + $points[$i+1]) / 2;  // Point médian
        $resultat += loi_inverse_gaussienne($m, $esperance, $forme);
    }

    $resultatFinal = $largeur * $resultat;

    // Assurer que le résultat ne dépasse pas 1
    return min($resultatFinal, 1);
}

function methode_trapezes($points, $esperance, $forme, $t) {
    $resultat = 0;
    $n = count($points) - 1;
    $largeur = $t / $n;

    for ($i = 0; $i < $n; $i++) {
        $resultat += loi_inverse_gaussienne($points[$i], $esperance, $forme) + loi_inverse_gaussienne($points[$i+1], $esperance, $forme);
    }

    return ($largeur * $resultat) / 2;
}

function methode_simpson($points, $esperance, $forme, $t) {
    $resultat = 0;
    $n = count($points) - 1;
    $largeur = $t / $n;

    $somme1 = 0;
    $somme2 = 0;

    for ($i = 1; $i < $n; $i += 2) {
        $somme1 += loi_inverse_gaussienne($points[$i], $esperance, $forme);
    }

    for ($j = 2; $j < $n-1; $j += 2) {
        $somme2 += loi_inverse_gaussienne($points[$j], $esperance, $forme);
    }

    $resultat = loi_inverse_gaussienne($points[0], $esperance, $forme) + loi_inverse_gaussienne($points[$n], $esperance, $forme) + 4 * $somme1 + 2 * $somme2;

    return ($largeur * $resultat) / 3;
}

function ecart_type($esperance, $forme) {
    return sqrt(pow($esperance, 3) / $forme);
}





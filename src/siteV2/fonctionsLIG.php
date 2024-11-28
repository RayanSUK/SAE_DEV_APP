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
    $n = count($points);

    for ($i = 0; $i < $n-1; $i++) {
        if ($points[$i + 1]) {
            $resultat += loi_inverse_gaussienne(($points[$i] + $points[$i + 1]) / 2, $esperance, $forme);
        }
    }

    return ($t*$resultat)/$n ;
}

function methode_trapezes($points, $esperance, $forme, $t){
    $resultat = 0;
    $n = count($points);

    for ($i = 1; $i < $n-1; $i++) {
        $resultat += loi_inverse_gaussienne($points[$i], $esperance, $forme);
    }

    $resultat *= 2;
    $resultat += loi_inverse_gaussienne($t, $esperance, $forme);

    return ($t*$resultat)/(2*$n) ;
}

function methode_simpson($points, $esperance, $forme, $t){
    $resultat = 0;
    $n = count($points);
    $somme1 = 0;
    $somme2 = 0;
    for ($i = 1; $i < $n-1; $i++) {
        $somme1 += loi_inverse_gaussienne(($i*$t)/$n, $esperance, $forme);
    }
    $somme1 *= 2;

    for ($j = 1; $j < $n-1; $j++) {
        $somme2 += loi_inverse_gaussienne(((2*$j + 1)*$t)/2*$n, $esperance, $forme);
    }
    $somme2 *= 4;

    $resultat += loi_inverse_gaussienne($t, $esperance, $forme) + $somme1 + $somme2;

    return ($t*$resultat)/(6*$n) ;
}

function ecart_type($esperance, $forme) {
    return sqrt(pow($esperance, 3) / $forme);
}





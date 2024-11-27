<?php
function loi_inverse_gaussienne($x, $esperance, $forme) {
    if ($x <= 0) {
        // Avoid division by zero by setting density to 0 for x <= 0
        return 0;
    } else {
        return sqrt($forme / (2 * pi() * pow($x, 3))) * exp(-($forme * pow($x - $esperance, 2)) / (2 * pow($esperance, 2) * $x));
    }
}

function methode_rectangles_medians($points, $esperance, $forme, $t) {

    $resultat = 0;
    $n = count($points) - 1;

    for ($i = 0; $i < $n; $i++) {
        if ($points[$i + 1]) {
            $resultat += loi_inverse_gaussienne(($points[$i] + $points[$i + 1]) / 2, $esperance, $forme);
        }
    }

    return $t * $resultat;
}

function ecart_type($esperance, $forme) {
    return sqrt(pow($esperance, 3) / $forme);
}





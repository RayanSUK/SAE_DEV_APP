<?php
function loi_inverse_gaussienne($x, $esperance, $forme) {
    if ($x == 0 || $forme == 0) {
        return 0; // Or handle it in another way, like returning an error
    }
    return sqrt($forme / (2 * M_PI * pow($x, 3))) * exp(-$forme * pow($x - $esperance, 2) / (2 * pow($esperance, 2) * $x));
}


function methode_rectangles_medians($n, $esperance, $forme, $t) {
    $h = $t / $n;
    $integral = 0.0;

    for ($i = 1; $i <= $n; $i++) {
        $x_i = $t + ($i - 0.5) * $h;
        $integral += loi_inverse_gaussienne($x_i, $esperance, $forme) * $h;
    }

    return $integral;
}

function methode_trapezes($n, $esperance, $forme, $t) {
    $h = $t / $n;
    $x = array();
    $y = array();

    // Calculer les points x et les valeurs de la fonction
    for ($i = 0; $i <= $n; $i++) {
        $x[] = $i * $h;
        $y[] = loi_inverse_gaussienne($x[$i], $esperance, $forme);
    }

    // Appliquer la formule des trapèzes
    $integral = $h * (0.5 * $y[0] + 0.5 * $y[$n]);

    // Somme des termes intermédiaires
    for ($i = 1; $i < $n; $i++) {
        $integral += $h * $y[$i];
    }

    return $integral;

}

function methode_simpson($n, $esperance, $forme, $t) {

    $h = $t / $n;
    $x = array();
    $y = array();

    // Calculer les points x et les valeurs de la fonction
    for ($i = 0; $i <= $n; $i++) {
        $x[] = $i * $h;
        $y[] = inverse_gaussian_pdf($x[$i], $esperance, $forme);
    }

    // Appliquer la formule de Simpson
    $integral = $h / 3 * ($y[0] + $y[$n]);
    $sum_odd = 0;
    $sum_even = 0;

    // Somme des termes impairs et pairs
    for ($i = 1; $i < $n; $i++) {
        if ($i % 2 == 0) {
            $sum_even += $y[$i];
        } else {
            $sum_odd += $y[$i];
        }
    }

    $integral += 4 * $sum_odd + 2 * $sum_even;

    return $integral;
}

function ecart_type($esperance, $forme) {
    return sqrt(pow($esperance, 3) / $forme);
}





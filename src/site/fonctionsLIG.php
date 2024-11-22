<?php
function loi_inverse_gaussienne($x, $esperance, $forme) {
    $densite = array();
    foreach ($x as $value) {
        if ($value < 0) {
            $densite[] = 0;
        } else {
            $densite[] = sqrt($forme / (2 * M_PI * pow($value, 3))) * exp(-$forme * pow(($value - $esperance), 2) / (2 * pow($esperance, 2) * $value));
        }
    }
    return $densite;
}

function methode_Des_Rectangles_Median($x, $esperance, $forme, $a, $b, $n) {
    for($i = 0; $i < $n-1; $i++){

    }
}

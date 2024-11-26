<?php
function loi_inverse_gaussienne($x_values, $esperance, $forme) {
    $densities = [];
    foreach ($x_values as $x) {
        if ($x <= 0) {
            // Avoid division by zero by setting density to 0 for x <= 0
            $density = 0;
        } else {
            $density = sqrt($forme / (2 * pi() * pow($x, 3))) * exp(-($forme * pow($x - $esperance, 2)) / (2 * pow($esperance, 2) * $x));
        }
        $densities[] = $density;
    }
    return $densities;
}




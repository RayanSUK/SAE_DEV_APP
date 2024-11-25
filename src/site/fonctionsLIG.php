<?php
function loi_inverse_gaussienne($x_values, $esperance, $forme) {
    $densities = [];
    foreach ($x_values as $x) {
        if ($x < 0) {
            // Avoid division by zero by setting density to 0 for x <= 0
            $density = 0;
        } else {
            $density = sqrt($forme / (2 * pi() * pow($x, 3))) * exp(-($forme * pow($x - $esperance, 2)) / (2 * pow($esperance, 2) * $x));
        }
        $densities[] = $density;
    }
    return $densities;
}


function methode_Des_Rectangles_Median($x_values, $esperance, $forme, $a, $b, $n) {
    $resultat = 0;
    for($i = 0; $i < $n-1; $i++){
        if($x_values[$i+1]){
            $resultat += loi_inverse_gaussienne(($x_values[$i] + $x_values[$i+1])/2, $esperance, $forme);

        }
    }

    return (($b-$a)/$n)*$resultat;
}

<?php
function loi_inverse_gaussienne($x, $esperance, $forme) {
    if ($x <= 0) {
        // Avoid division by zero by setting density to 0 for x <= 0
        return 0;
    } else {
        return sqrt($forme / (2 * pi() * pow($x, 3))) * exp(-($forme * pow($x - $esperance, 2)) / (2 * pow($esperance, 2) * $x));
    }
}

function methode_rectangles_medians($points, $esperance, $forme, $a, $b, $n){
    $h = ($b-$a)/$n;
    $resultat = 0;
    for($i = 0; $i < $n-1; $i++){
        if($points[$i+1]){
            $resultat += loi_inverse_gaussienne(($points[$i]+$points[$i+1])/2, $esperance, $forme);
        }
    }

    return $h*$resultat;
}




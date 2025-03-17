<?php
// Fonction pour calculer le discriminant
function discriminant($a, $b, $c) {
    return pow($b, 2) - (4 * $a * $c);
}

// Fonction pour calculer la première solution (racine réelle) lorsque le discriminant est positif
function racineReelle1($a, $b, $c) {
    return (-$b - sqrt(discriminant($a, $b, $c))) / (2 * $a);
}

// Fonction pour calculer la deuxième solution (racine réelle) lorsque le discriminant est positif
function racineReelle2($a, $b, $c) {
    return (-$b + sqrt(discriminant($a, $b, $c))) / (2 * $a);
}

// Fonction pour calculer la solution unique lorsque le discriminant est nul
function racineUnique($a, $b) {
    return -$b / (2 * $a);
}

// Fonction pour calculer la première solution complexe lorsque le discriminant est négatif
function racineComplexe1($a, $b, $c) {
    $partieReelle = -$b / (2 * $a);
    $partieImaginaire = sqrt(-discriminant($a, $b, $c)) / (2 * $a);
    return [$partieReelle, -$partieImaginaire]; // Retourne un tableau [partie réelle, partie imaginaire]
}

// Fonction pour calculer la deuxième solution complexe lorsque le discriminant est négatif
function racineComplexe2($a, $b, $c) {
    $partieReelle = -$b / (2 * $a);
    $partieImaginaire = sqrt(-discriminant($a, $b, $c)) / (2 * $a);
    return [$partieReelle, $partieImaginaire]; // Retourne un tableau [partie réelle, partie imaginaire]
}
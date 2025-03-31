<?php
/**
 * Calcule le discriminant d'une équation  ax² + bx + c = 0.
 *
 * @param float $a Coefficient de x².
 * @param float $b Coefficient de x.
 * @param float $c Terme constant.
 * @return float Valeur du discriminant.
 */
function discriminant($a, $b, $c) {
    return pow($b, 2) - (4 * $a * $c);
}

// Fonction pour calculer la première solution (racine réelle) lorsque le discriminant est positif
/**
 * Calcule la première racine réelle de l'équation si le discriminant est positif.
 *
 * @param float $a Coefficient de x².
 * @param float $b Coefficient de x.
 * @param float $c Terme constant.
 * @return float Valeur de la première racine réelle.
 */
function racineReelle1($a, $b, $c) {
    return (-$b - sqrt(discriminant($a, $b, $c))) / (2 * $a);
}

// Fonction pour calculer la deuxième solution (racine réelle) lorsque le discriminant est positif
/**
 * Calcule la deuxième racine réelle de l'équation si le discriminant est positif.
 *
 * @param float $a Coefficient de x².
 * @param float $b Coefficient de x.
 * @param float $c Terme constant.
 * @return float Valeur de la deuxième racine réelle.
 */
function racineReelle2($a, $b, $c) {
    return (-$b + sqrt(discriminant($a, $b, $c))) / (2 * $a);
}

// Fonction pour calculer la solution unique lorsque le discriminant est nul
/**
 * Calcule la racine unique de l'équation si le discriminant est nul.
 *
 * @param float $a Coefficient de x².
 * @param float $b Coefficient de x.
 * @return float Valeur de la racine unique.
 */
function racineUnique($a, $b) {
    return -$b / (2 * $a);
}

// Fonction pour calculer la première solution complexe lorsque le discriminant est négatif
/**
 * Calcule la première solution complexe de l'équation si le discriminant est négatif.
 *
 * @param float $a Coefficient de x².
 * @param float $b Coefficient de x.
 * @param float $c Terme constant.
 * @return array Tableau contenant la partie réelle et imaginaire de la première solution complexe.
 */
function racineComplexe1($a, $b, $c) {
    $partieReelle = -$b / (2 * $a);
    $partieImaginaire = sqrt(-discriminant($a, $b, $c)) / (2 * $a);
    return [$partieReelle, -$partieImaginaire]; // Retourne un tableau [partie réelle, partie imaginaire]
}

// Fonction pour calculer la deuxième solution complexe lorsque le discriminant est négatif
/**
 * Calcule la deuxième solution complexe de l'équation quadratique si le discriminant est négatif.
 *
 * @param float $a Coefficient de x².
 * @param float $b Coefficient de x.
 * @param float $c Terme constant.
 * @return array Tableau contenant la partie réelle et imaginaire de la deuxième solution complexe.
 */
function racineComplexe2($a, $b, $c) {
    $partieReelle = -$b / (2 * $a);
    $partieImaginaire = sqrt(-discriminant($a, $b, $c)) / (2 * $a);
    return [$partieReelle, $partieImaginaire]; // Retourne un tableau [partie réelle, partie imaginaire]
}
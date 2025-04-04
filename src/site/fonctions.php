<?php

/**
 * Génère un captcha sous forme d'une addition entre deux nombres aléatoires.
 *
 * Cette fonction génère deux nombres aléatoires entre 0 et 9, puis les additionne pour créer un captcha.
 * Le résultat de cette addition est stocké dans la session pour validation ultérieure.
 * Elle retourne les deux nombres pour affichage dans l'interface.
 *
 * @return array Contient les deux nombres générés pour l'addition (par exemple, [3, 7]).
 */
function Captcha() {
    // Générer deux nombres aléatoires
    $num1 = rand(0, 9);
    $num2 = rand(0, 9);

    // Stocker le résultat attendu dans la session
    $_SESSION['captcha'] = $num1 + $num2;

    // Retourner l'affichage de l'addition
    return [$num1, $num2];
}

/**
 * Chiffre ou déchiffre une donnée en utilisant l'algorithme RC4.
 *
 * Cette fonction utilise l'algorithme RC4 pour chiffrer ou déchiffrer des données en fonction de la clé
 * fournie. Le chiffrement ou le déchiffrement se fait en appliquant l'algorithme Key Scheduling Algorithm
 * (KSA) et Pseudo-Random Generation Algorithm (PRGA).
 *
 * @param string $key  Clé de chiffrement. Cette clé est utilisée pour le chiffrement et le déchiffrement des données.
 * @param string $data Données à chiffrer ou déchiffrer. Les données peuvent être n'importe quelle chaîne de caractères.
 * @return string Résultat du chiffrement ou du déchiffrement. La chaîne de caractères résultante est obtenue après l'application de l'algorithme RC4.
 */
function rc4($key, $data) {
    $key = array_values(unpack('C*', $key));
    $data = array_values(unpack('C*', $data));
    $S = range(0, 255);
    $j = 0;
    
    // Key Scheduling Algorithm (KSA)
    for ($i = 0; $i < 256; $i++) {
        $j = ($j + $S[$i] + $key[$i % count($key)]) % 256;
        [$S[$i], $S[$j]] = [$S[$j], $S[$i]];
    }
    
    // Pseudo-Random Generation Algorithm (PRGA)
    $i = $j = 0;
    $output = '';
    foreach ($data as $byte) {
        $i = ($i + 1) % 256;
        $j = ($j + $S[$i]) % 256;
        [$S[$i], $S[$j]] = [$S[$j], $S[$i]];
        $output .= chr($byte ^ $S[($S[$i] + $S[$j]) % 256]);
    }
    return $output;
}

/**
 * Permet d'obtenir l'IP de l'utilisateur.
 *
 * Cette fonction utilise les superglobales inclues dans PHP afin de récupérer l'adresse IP de l'utilisateur
 * Elle d'assurer une récupération de l'IP réelle. Peut aider si l'utilisateur utilise un proxy par exemple
 *
 * @return string Adresse IP (IPv4 ou IPv6) de l'utilisateur.
 */
function getUserIP() {
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return filter_var(explode(',', $ip)[0], FILTER_VALIDATE_IP);
}
?>

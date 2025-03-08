<?php
function Captcha() {
    // Générer deux nombres aléatoires
    $num1 = rand(0, 9);
    $num2 = rand(0, 9);

    // Stocker le résultat attendu dans la session
    $_SESSION['captcha'] = $num1 + $num2;

    // Retourner l'affichage de l'addition
    return [$num1, $num2];
}

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
?>

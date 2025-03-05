<?php 
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}
include('partiels/navbar.php');

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $key = $_POST['key'] ?? '';
    $text = $_POST['text'] ?? '';
    $action = $_POST['action'] ?? '';
    
    if ($key && $text) {
        if ($action === 'encrypt') {
            $result = bin2hex(rc4($key, $text));
        } elseif ($action === 'decrypt') {
            $result = rc4($key, hex2bin($text));
        }
    }
}
?>

<main role="main">
    <section class="description text-center">
        <div class="titre text-center">
            <h1>Module 2 - Chiffrement/Déchiffrement RC4</h1>
        </div>
        <form method="post">
            <label for="key">Clé :</label>
            <input type="text" name="key" required>
            <label for="text">Texte :</label>
            <input type="text" name="text" required>
            <button type="submit" name="action" value="encrypt">Chiffrer</button>
            <button type="submit" name="action" value="decrypt">Déchiffrer</button>
        </form>
        <?php if (isset($result)): ?>
            <p>Résultat : <strong><?php echo htmlspecialchars($result); ?></strong></p>
        <?php endif; ?>
    </section>
</main>

<?php include('partiels/footer.php'); ?>

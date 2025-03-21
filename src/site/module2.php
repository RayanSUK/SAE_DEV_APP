<?php 
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}
include('partiels/navbar.php');
include('fonctions.php');


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

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Module Crypto.</title>
</head>


<button id="openPopup" class="info-button text-center">ℹ️ Cliquez ICI pour voir l'explication du module !!</button>

<main role="main">
    <div id="popup" class="popup">
    <div class="popup-content text-center">
        <span class="close">&times;</span>
        <div class="container">
            <h1>🔐 Module de Cryptographie : Chiffrement RC4</h1>
            <p>
                Découvrez notre module interactif dédié au <strong>chiffrement RC4</strong>, un algorithme de chiffrement par flux largement utilisé
                en cryptographie. Cet outil vous permet d'expérimenter le chiffrement et le déchiffrement de messages en utilisant une clé secrète.
            </p>

            <h2>🛠 Comment ça marche ?</h2>
            <ol>
                <li><strong>Entrez vos paramètres :</strong></li>
                <ul>
                    <li><strong>Clé :</strong> Une suite de caractères utilisée pour chiffrer et déchiffrer le texte.</li>
                    <li><strong>Texte :</strong> Le message que vous souhaitez chiffrer ou déchiffrer.</li>
                </ul>
                <li><strong>Lancez l'opération :</strong></li>
                <ul>
                    <li>Choisissez entre <strong>chiffrement</strong> et <strong>déchiffrement</strong>.</li>
                </ul>
                <li><strong>Obtenez vos résultats :</strong></li>
                <ul>
                    <li>Visualisez immédiatement le texte transformé et comprenez l'impact de votre clé sur l'encodage.</li>
                </ul>
            </ol>
        </div>
    </div>
    </div>


    <section class="description text-center">

        <div class="form-container-parent">
            <div class="form-container-co">
                <h1>Module 2 - Chiffrement/Déchiffrement RC4</h1>
                <form method="POST" action="#">
                    <label for="key">Clé :</label>
                    <input type="text" name="key" id="key" placeholder="Entrez la clé" required>

                    <label for="text">Texte :</label>
                    <input type="text" name="text" id="text" placeholder="Entrez le texte" required>

                    <button type="submit" name="action" value="encrypt">Chiffrer</button>
                    <button type="submit" name="action" value="decrypt">Déchiffrer</button>
                </form>
            </div>
        </div>
        <?php if (isset($result)): ?>
            <p>Résultat : <strong><?php echo htmlspecialchars($result); ?></strong></p>
        <?php endif; ?><br><br><br><br>
    </section>


    
    <script>
        //Ce script permet de mettre les instructions dans un menu déroulant. Permet d'améliorer l'expérience utilisateur
    document.addEventListener("DOMContentLoaded", function () {
        var openPopupBtn = document.getElementById("openPopup");
        var popup = document.getElementById("popup");
        var closePopupBtn = document.querySelector(".close");

        if (openPopupBtn && popup && closePopupBtn) {
            openPopupBtn.addEventListener("click", function () {
                popup.style.display = "block";
            });

            closePopupBtn.addEventListener("click", function () {
                popup.style.display = "none";
            });

            window.addEventListener("click", function (event) {
                if (event.target === popup) {
                    popup.style.display = "none";
                }
            });
        }
    });
</script>
 
</main>

<?php include('partiels/footer.php'); ?>

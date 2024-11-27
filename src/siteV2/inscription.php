<?php
include('partiels/navbar_Inscription.php');
session_start();

if (!isset($_SESSION['captcha'])) {
    $tab = range(0, 9);
    shuffle($tab);
    $_SESSION['captcha'] = $tab[0];
}
$nb = $_SESSION['captcha'];

// Créez le fichier CSV si nécessaire
if (!file_exists('utilisateurs.csv')) {
    $fp = fopen('utilisateurs.csv', 'w');
    fputcsv($fp, ['ID', 'PASSWORD', 'CAPTCHA', 'IP', 'DATE']); // En-tête
    fclose($fp);
}

// Traitement du formulaire d'inscription
if (isset($_POST['nom'], $_POST['mdp'], $_POST['reponse'])) {
    $nom = $_POST['nom'];
    $mdp = $_POST['mdp'];
    $reponse = $_POST['reponse'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $date = date("Y-m-d H:i:s");

    if ($reponse == $_SESSION['captcha']) {
        // Enregistrer dans le fichier CSV sans hachage
        $fp = fopen('utilisateurs.csv', 'a');
        fputcsv($fp, [$nom, $mdp, $ip, $date]);
        fclose($fp);

        $_SESSION['nom'] = $nom;
        $_SESSION['etat'] = 'inscription';
        unset($_SESSION['captcha']); // Supprimer le CAPTCHA après utilisation
        header("Location: accueil.php");
        exit;
    } else {
        echo "<p style='background-color: red; color: white;'>Captcha incorrect.</p>";
    }
}
?>


<!-- Formulaire d'inscription -->
<section class="description text-center">
    <div class="titreInscrit">
        <h1>Inscription</h1>
    </div>
    <div class="form-container-parent">
        <div class="form-container-co">
            <h1>Inscription</h1>
            <form method="POST">
                <input type="text" name="nom" placeholder="Pseudo" required>
                <input type="password" name="mdp" placeholder="Mot de passe" required>
                <p>Veuillez sélectionner le chiffre <span style="font-weight: bold; color: red;"><?= $nb ?></span> pour valider votre inscription :</p>
                <table>
                    <tr>
                        <?php foreach (range(0, 9) as $value): ?>
                            <td>
                                <button type="submit" name="reponse" value="<?= $value ?>" 
                                        <?= $value == $nb ? 'style="background-color: red;"' : '' ?>>
                                    <?= $value ?>
                                </button>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</section>

<?php include('partiels/footer.php'); ?>
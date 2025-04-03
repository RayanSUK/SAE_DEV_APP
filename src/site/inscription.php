<?php
/**
 * Démarre la session PHP et configure l'affichage des erreurs.
 */
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/**
 * Inclusion de la barre de navigation pour l'inscription.
 */
include('partiels/navbar_Inscription.php');
/**
 * Inclusion de la fonction RC4 pour le chiffrement du mot de passe.
 */
require_once('fonctions.php'); // Inclusion de la fonction RC4
/**
 * Génère un CAPTCHA aléatoire si ce n'est pas déjà fait.
 * Le CAPTCHA est stocké dans la session de l'utilisateur.
 */
if (!isset($_SESSION['captcha'])) {
    $tab = range(0, 9);
    shuffle($tab);
    $_SESSION['captcha'] = $tab[0];
}

$nb = $_SESSION['captcha'];

/**
 * Connexion à la base de données MySQL.
 *
 * Si la connexion échoue, le script s'arrête et affiche un message d'erreur.
 */
$cnx = mysqli_connect('localhost', 'root', 'root', 'sigmax');
if (!$cnx) {
    die("Échec de la connexion à la base de données: " . mysqli_connect_error());
}

/**
 * Récupération de la clé de chiffrement RC4 depuis la base de données.
 *
 * La clé est utilisée pour le chiffrement des mots de passe lors de l'inscription.
 */
$key_query = "SELECT cle_rc4 FROM cle LIMIT 1";
$key_result = mysqli_query($cnx, $key_query);
$key_row = mysqli_fetch_assoc($key_result);
$key = $key_row['cle_rc4'];

/**
 * Traitement du formulaire d'inscription.
 *
 * Vérifie les données saisies par l'utilisateur, y compris le mot de passe et la réponse au CAPTCHA.
 * Si les données sont valides, le mot de passe est chiffré et l'utilisateur est inscrit.
 *
 * @param string $nom Le pseudo de l'utilisateur.
 * @param string $mdp Le mot de passe de l'utilisateur.
 * @param int $reponse La réponse au CAPTCHA.
 */
if (isset($_POST['nom'], $_POST['mdp'], $_POST['reponse'])) {
    $nom = $_POST['nom'];
    $mdp = $_POST['mdp'];
    $reponse = $_POST['reponse'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $date = date("Y-m-d H:i:s");

    if (strlen($mdp) < 8) {
        $_SESSION['error'] = "Le mot de passe doit contenir au moins 8 caractères.";
        header("Location: inscription.php");
        exit;
    }

    // Chiffrement du mot de passe avec RC4
    $mdp_chiffre = bin2hex(rc4($key, $mdp));

    if ($reponse == $_SESSION['captcha']) {
        // Vérifie si le login est déjà utilisé
        $check_sql = "SELECT * FROM users WHERE login = ?";
        $check_stmt = mysqli_prepare($cnx, $check_sql);
        mysqli_stmt_bind_param($check_stmt, "s", $nom);
        mysqli_stmt_execute($check_stmt);
        $check_result = mysqli_stmt_get_result($check_stmt);

        if (mysqli_num_rows($check_result) > 0) {
            $_SESSION['error'] = "Login déjà utilisé.";
            header("Location: inscription.php");
            exit;
        } else {
            // Insère dans la base de données
            $sql = "INSERT INTO users (login, password) VALUES (?, ?)";
            $stmt = mysqli_prepare($cnx, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $nom, $mdp_chiffre);

            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['login'] = $nom;
                $_SESSION['id'] = mysqli_insert_id($cnx);
                $_SESSION['etat'] = 'inscription';
                header("Location: accueil.php");
                exit;
            } else {
                $_SESSION['error'] = "Erreur lors de l'inscription.";
                header("Location: inscription.php");
                exit;
            }
        }

        // Fermeture des requêtes préparées
        mysqli_stmt_close($check_stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($cnx);
        unset($_SESSION['captcha']); // Supprimer le CAPTCHA après utilisation
        exit;
    } else {
        echo "<p style='background-color: red; color: white;'>Captcha incorrect.</p>";
    }
    session_unset();
}
?>

<!-- Formulaire d'inscription -->
<main role="main">
    <section class="description text-center" role="region" aria-labelledby="titre-inscription">
        <div class="titreInscrit">
            <h1 id="titre-inscription">Inscription</h1>
        </div>
        <div class="form-container-parent">
            <div class="form-container-co">
                <h2>Inscription</h2>
                <form method="POST">
                    <label for="nom">Pseudo :</label>
                    <input type="text" name="nom" id="nom" placeholder="Pseudo" required>

                    <label for="mdp">Mot de passe :</label>
                    <input type="password" name="mdp" id="mdp" placeholder="Mot de passe" required>

                    <p>Veuillez sélectionner le chiffre <span style="font-weight: bold; color: rgba(182,4,4,0.89);">
                        <?= $nb ?></span> pour valider votre inscription :</p>

                    <!-- Boutons de validation sous forme de Flexbox -->
                    <div style="display: flex; justify-content: center; gap: 10px; flex-wrap: wrap;">
                        <?php foreach (range(0, 9) as $value): ?>
                            <button type="submit" name="reponse" value="<?= $value ?> "
                                <?= $value == $nb ? 'style="background-color: rgba(182,4,4,0.89);"' : '' ?> >
                                <?= $value ?>
                            </button>
                        <?php endforeach; ?>
                    </div>

                    <br>
                    <?php
                    if (isset($_SESSION['error'])) {
                        echo '<p style="color: rgba(182,4,4,0.89);">' . $_SESSION['error'] . '</p>';
                        unset($_SESSION['error']);
                    }
                    ?>
                </form>
            </div>
        </div>
    </section>
</main>

<?php include('partiels/footer.php'); ?>

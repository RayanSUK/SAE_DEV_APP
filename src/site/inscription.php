<!-- Ajout du titre d'onglet -->
<title>Inscription</title>

<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('partiels/navbar_Inscription.php');


if (!isset($_SESSION['captcha'])) {
    $tab = range(0, 9);
    shuffle($tab);
    $_SESSION['captcha'] = $tab[0];
}

$nb = $_SESSION['captcha'];

// Traitement du formulaire d'inscription
if (isset($_POST['nom'], $_POST['mdp'], $_POST['reponse'])) {
    $nom = $_POST['nom'];
    $mdp = md5($_POST['mdp']);
    $reponse = $_POST['reponse'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $date = date("Y-m-d H:i:s");

    if (strlen($_POST['mdp']) < 8) {
        $_SESSION['error'] = "Le mot de passe doit contenir au moins 8 caractères.";
        header("Location: inscription.php");
        exit;
    }

    $mdp = md5($_POST['mdp']);

    if ($reponse == $_SESSION['captcha']) {
        // Connexion à la base de données
        $cnx = mysqli_connect('localhost', 'root', 'root', 'sigmax');
        if (!$cnx) {
            die("Échec de la connexion à la base de données: " . mysqli_connect_error());
        }

        // Vérifie si le login est déjà utilisé
        $check_sql = "SELECT * FROM users WHERE login = ?";
        $check_stmt = mysqli_prepare($cnx, $check_sql);
        mysqli_stmt_bind_param($check_stmt, "s", $nom);
        mysqli_stmt_execute($check_stmt);
        $check_result = mysqli_stmt_get_result($check_stmt);

        if (mysqli_num_rows($check_result) > 0) {
            // Le login est déjà utilisé : renvoie un message d'erreur et l'utilisateur doit recommencer
            $_SESSION['error'] = "Login déjà utilisé.";
            header("Location: inscription.php");
            exit;
        } else {
            // Insère dans la base de données
            $sql = "INSERT INTO users (login, password) VALUES (?, ?)";
            $stmt = mysqli_prepare($cnx, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $nom, $mdp);

            if (mysqli_stmt_execute($stmt)) {
                // Connexion de l'utilisateur après inscription
                $_SESSION['login'] = $nom;  // Ajoute le login à la session
                $_SESSION['id'] = mysqli_insert_id($cnx);  // Récupère l'ID de l'utilisateur inscrit
                $_SESSION['etat'] = 'inscription';  // Indique que l'inscription a réussi

                // Redirection vers accueil.php
                header("Location: accueil.php");
                exit;
            } else {
                // Message affiché en cas d'erreurs
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

                    <p>Veuillez sélectionner le chiffre <span style="font-weight: bold; color: rgba(182,4,4,0.89);"><?= $nb ?></span> pour valider votre inscription :</p>

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

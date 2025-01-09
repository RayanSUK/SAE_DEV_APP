<?php
include('partiels/navbar_Inscription.php');
session_start();

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

    if ($reponse == $_SESSION['captcha']) {
        // Connexion à la base de données
        $cnx = mysqli_connect('localhost', 'root', 'root', 'sigmax');
        if (!$cnx) {
            die("Échec de la connexion à la base de données: " . mysqli_connect_error());
        }

        // Vérifie si le login est déjà utilisé
        $check_sql = "SELECT * FROM USERS WHERE login = ?";
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
            $sql = "INSERT INTO USERS (login, password) VALUES (?, ?)";
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
                <br>
                <?php
                if (isset($_SESSION['error'])) {
                    echo '<p style="color: red;">' . $_SESSION['error'] . '</p>';
                    unset($_SESSION['error']);
                }
                ?>
            </form>
        </div>
    </div>
</section>

<?php include('partiels/footer.php'); ?>

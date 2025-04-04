<?php
/**
 * Démarre la session pour l'utilisateur et inclut la fonction RC4.
 *
 * Cette page contient la logique de connexion des utilisateurs. Elle vérifie les informations d'identification
 * dans la base de données et redirige l'utilisateur en fonction de son rôle.
 */
session_start();
/**
 * Inclusion du fichier contenant la fonction RC4 pour le chiffrement/déchiffrement.
 */
require_once('fonctions.php'); // Inclusion de la fonction RC4
?>

<?php include('partiels/navbar_Inscription.php'); ?>

<main role="main">
<!-- Section de connexion -->
<section class="description text-center">
    <div class="titreInscrit">
        <h1>Connexion</h1>
    </div>
    <div class="form-container-parent">
        <div class="form-container-co">
            <h1>Connexion</h1>
            <form method="POST" action="#">
                <label for="nom">Pseudo :</label>
                <input type="text" name="nom" id="nom" placeholder="Pseudo" required>

                <label for="mdp">Mot de passe :</label>
                <input type="password" name="mdp" id="mdp" placeholder="Mot de passe" required>

                <button type="submit" name="acces">Se connecter</button>
            </form>
        </div>
    </div>
</section>
</main>

</body>
</html>

<?php


// Connexion à la base de données
$cnx = mysqli_connect('localhost', 'root', 'root', 'sigmax');
if (!$cnx) {
    die("Échec de connexion à la base de données : " . mysqli_connect_error());
}
/**
 * Traitement du formulaire de connexion.
 *
 * Lorsque l'utilisateur soumet le formulaire, les informations sont récupérées via `$_POST`.
 * Le mot de passe est ensuite chiffré avec l'algorithme RC4 et comparé avec celui stocké dans la base de données.
 * Si les informations sont correctes, une session est ouverte et l'utilisateur est redirigé en fonction de son rôle.
 * Si les informations sont incorrectes, un message d'erreur est affiché.
 */

if (isset($_POST['nom'], $_POST['mdp'], $_POST['acces'])) {
    $nom = $_POST['nom'];
    $mdp = $_POST['mdp'];
    $ip = getUserIP();
    $jour = date('Y-m-d');
    $heure = date('H:i:s');

    // Récupération de la clé RC4 depuis la base de données
    $key_query = "SELECT cle_rc4 FROM cle LIMIT 1";
    $key_result = mysqli_query($cnx, $key_query);
    $key_row = mysqli_fetch_assoc($key_result);
    $key = $key_row['cle_rc4'];

    $mdp_chiffre = bin2hex(rc4($key, $mdp)); // Chiffrement du mot de passe

    // Préparation et exécution de la requête pour récupérer les informations de l'utilisateur
    $query = "SELECT * FROM users WHERE login = ?";
    $stmt = mysqli_prepare($cnx, $query);
    mysqli_stmt_bind_param($stmt, "s", $nom);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // Comparaison du mot de passe saisi avec celui stocké dans la base
        if ($mdp_chiffre === $row['password']) {
            // Connexion réussie
            $_SESSION['login'] = $row['login'];
            $_SESSION['id'] = $row['id'];
            $_SESSION['etat'] = 'connexion';

            // Enregistrement de la connexion réussie
            $log_query = "INSERT INTO adminsysteme (jour, heure, ip, login, statut) VALUES (?, ?, ?, ?, 'connexion réussie')";
            $log_stmt = mysqli_prepare($cnx, $log_query);
            mysqli_stmt_bind_param($log_stmt, "ssss", $jour, $heure, $ip, $row['login']);
            mysqli_stmt_execute($log_stmt);
            mysqli_stmt_close($log_stmt);

            // Vérification si l'utilisateur est l'adminweb
            if ($row['login'] === 'adminweb') {
                $_SESSION['role'] = 'adminweb';
                header("Location: adminweb.php");
            } elseif ($row['login'] === 'adminsys') {
                $_SESSION['role'] = 'adminsys';
                header("Location: adminsys.php");
            } else {
                $_SESSION['role'] = 'user';
                header("Location: accueil.php");
            }
            exit;
        } else {
            echo "<p style='color:red; text-align: center;'>Mot de passe incorrect.</p>";
            $login_tente = $nom;
        }
    } else {
        echo "<p style='color:red; text-align: center;'>Utilisateur non trouvé.</p>";
        $login_tente = $nom;
    }

    // Enregistrement de la tentative échouée
    $log_query = "INSERT INTO adminsysteme (jour, heure, ip, login, statut) VALUES (?, ?, ?, ?, 'échec de la connexion')";
    $log_stmt = mysqli_prepare($cnx, $log_query);
    mysqli_stmt_bind_param($log_stmt, "ssss", $jour, $heure, $ip, $login_tente);
    mysqli_stmt_execute($log_stmt);
    mysqli_stmt_close($log_stmt);

    // Fermeture de la requête et de la connexion
    mysqli_stmt_close($stmt);
    mysqli_close($cnx);
}
?>

<?php include('partiels/footer.php'); ?>

<?php
session_start();
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
if (isset($_POST['nom'], $_POST['mdp'], $_POST['acces'])) {
    $nom = $_POST['nom'];
    $mdp = $_POST['mdp'];
    $key = "saesigmax";
    $mdp_chiffre = bin2hex(rc4($key, $mdp)); // Chiffrement du mot de passe

    // Connexion à la base de données
    $cnx = mysqli_connect('localhost', 'root', 'root', 'sigmax');
    if (!$cnx) {
        die("Échec de connexion à la base de données : " . mysqli_connect_error());
    }

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

            // Vérification si l'utilisateur est l'adminweb
            if ($row['login'] === 'adminweb') {
                $_SESSION['role'] = 'adminweb';
                header("Location: adminweb.php");
            } else {
                $_SESSION['role'] = 'user';
                header("Location: accueil.php");
            }
            exit;
        } else {
            echo "<p style='color:red; text-align: center;'>Mot de passe incorrect.</p>";
        }
    } else {
        echo "<p style='color:red; text-align: center;'>Utilisateur non trouvé.</p>";
    }

    // Fermeture de la requête et de la connexion
    mysqli_stmt_close($stmt);
    mysqli_close($cnx);
}
?>

<?php include('partiels/footer.php'); ?>

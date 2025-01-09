<?php
session_start();
?>

<?php include('partiels/navbar_Inscription.php'); ?>

<!-- Section de connexion -->
<section class="description text-center">
    <div class="titreInscrit">
        <h1>Connexion</h1>
    </div>
    <div class="form-container-parent">
        <div class="form-container-co">
            <h1>Connexion</h1>
            <form method="POST" action="#">
                <input type="text" name="nom" placeholder="Pseudo" required>
                <input type="password" name="mdp" placeholder="Mot de passe" required>
                <button type="submit" name="acces">Se connecter</button>
            </form>
        </div>
    </div>
</section>


</body>
</html>

<?php
if (isset($_POST['nom'], $_POST['mdp'], $_POST['acces'])) {
    $nom = $_POST['nom'];
    $mdp = $_POST['mdp'];

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
        if (md5($mdp) === $row['password']) {
            // Connexion réussie
            $_SESSION['login'] = $row['login'];  // Ajoute le login dans la session
            $_SESSION['user_id'] = $row['id'];   // Ajoute l'ID utilisateur dans la session
            $_SESSION['etat'] = 'connexion';     // Définit l'état de connexion

            // Vérification si l'utilisateur est l'adminweb
            if ($row['login'] === 'adminweb') {
                $_SESSION['role'] = 'adminweb';  // Ajoute le rôle adminweb
                header("Location: adminweb.php");   // Redirection vers la page admin
            } else {
                $_SESSION['role'] = 'user';      // Ajoute le rôle utilisateur normal
                header("Location: accueil.php"); // Redirection vers la page d'accueil
            }
            exit;
        } else {
            echo "<p style='color:red;' class="text-center">Mot de passe incorrect.</p>";
        }
    } else {
        echo "<p style='color:red;'>Utilisateur non trouvé.</p>";
    }

    // Fermeture de la requête et de la connexion
    mysqli_stmt_close($stmt);
    mysqli_close($cnx);
}
?>

<?php include('partiels/footer.php'); ?>

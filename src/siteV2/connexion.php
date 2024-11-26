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
        <div class="form-container-co"> <!-- Nouvelle classe spécifique à la connexion -->
            <h1>Connexion</h1>
            <form method="POST" action="#">
                <input type="text" name="nom" placeholder="Pseudo" required>
                <input type="password" name="mdp" placeholder="Mot de passe" required>
                <button type="submit" name="acces">Se connecter</button>
            </form>
        </div>
    </div>

</section>

<?php include('partiels/footer.php'); ?>

</body>
</html>

<?php

if (isset($_POST['nom'], $_POST['mdp'], $_POST['acces'])) {
    $nom = $_POST['nom'];
    $mdp = $_POST['mdp'];

    // Vérification pour l'administrateur système
    if ($nom === 'sysadmin' && $mdp === 'sysadmin') {
        // Enregistrer l'état de l'utilisateur admin
        $_SESSION['nom'] = $nom;
        $_SESSION['etat'] = 'admin';
        header('Location: inscritcsv.php'); // Redirection vers la page d'administration
        exit;
    }

    if($nom === 'adminweb' && $mdp === 'adminweb'){
        $_SESSION['nom']= $nom;
        $_SESSION['etat'] = 'adminweb';
        header('Location: adminweb.php');

    }

    $fp = fopen('utilisateurs.csv', 'r');
    $identifiantsCorrects = false;

    while ($row = fgetcsv($fp, 1024, ",")) {
        if (count($row) >= 2) { // Vérifiez que la ligne est valide
            $stored_nom = $row[0];
            $stored_mdp = $row[1];
            if ($nom === $stored_nom && $mdp === $stored_mdp) {
                $identifiantsCorrects = true;
                break;
            }
        }
    }
    fclose($fp);

    if ($identifiantsCorrects) {
        $_SESSION['nom'] = $nom;
        $_SESSION['etat'] = 'connexion';
        header('Location: accueil.php');
        exit;
    } else {
        echo "<p style='background-color: red; color: white; text-align: center;'>Identifiants incorrects</p>";
    }
}
?>

<?php
session_start();
include_once("fonctions.php");

if (isset($_POST['ok'])) {
    $login = $_POST['login'];
    $password = md5($_POST['password']);
    $userCaptcha = (int)$_POST['captcha'];

    // Vérifie si les champs ne sont pas vides
    if (empty($login) || empty($password)) {
        echo "<p style='color:red;'>Veuillez remplir tous les champs.</p>";
    } else {


        // Connexion à la base de données
        $cnx = mysqli_connect('localhost', 'root', 'root', 'sigmax');
        if (!$cnx) {
            die("Échec de la connexion à la base de données: " . mysqli_connect_error());
        }


        // Vérifie si le login est déjà utilisé
        $check_sql = "SELECT * FROM USERS WHERE login = ?";
        $check_stmt = mysqli_prepare($cnx, $check_sql);
        mysqli_stmt_bind_param($check_stmt, "s", $login);
        mysqli_stmt_execute($check_stmt);
        $check_result = mysqli_stmt_get_result($check_stmt);


        if (mysqli_num_rows($check_result) > 0) {
            // Le login est déjà utilisé : renvoie un message d'erreur et l'utilisateur doit recommencer
            header("Location:inscriptionbdd.php");
            $_SESSION['error'] = "Login déjà utilisé.";

        } elseif ($userCaptcha !== $_SESSION['captcha']) {
            // Le captcha est incorrect : renvoie un message d'erreur et l'utilisateur doit recommencer
            header("Location:inscriptionbdd.php");
            $_SESSION['error'] = "Le captcha est incorrect. Réessayez.";

        } else {
            // Insére dans la base de données
            $sql = "INSERT INTO USERS (login, password) VALUES (?, ?)";
            $stmt = mysqli_prepare($cnx, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $login, $password);

            if (mysqli_stmt_execute($stmt)) {
                // Message affiché si l'inscription est réussie
                echo "<p style='color:green;'>Inscription validée !</p>";
            } else {
                // Message affiché en cas d'erreurs
                $_SESSION['error'] = "Erreur lors de l'inscription.";
                header("Location:inscriptionbdd.php");
            }
        }

        // Fermeture des requêtes préparées
        mysqli_stmt_close($check_stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($cnx);
    }
    session_unset();
}
?>

<h1>Inscription</h1>

<?php
if (isset($_SESSION['error'])) {
    echo '<p style="color: red;">' . $_SESSION['error'] . '</p>';
    unset($_SESSION['error']);
}

list($num1, $num2) = Captcha()
?>

<form method="post">
    <label for="login" style="font-weight: bold;">Login :</label>
    <input type="text" name="login" id="login" required>
    <br><br>
    <label for="password" style="font-weight: bold;">Mot de Passe :</label>
    <input type="password" name="password" id="password" required>
    <br><br>
    <label for="captcha" style="font-weight: bold;">Captcha :</label>
    <p><?php echo $num1 . " + " . $num2 . " = ?"; ?></p>
    <input type='number' name='captcha' placeholder="Entrez le résultat de l'addition" style="width:20%" required>
    <br><br>
    <input type="submit" value="S'inscrire" name="ok">
    <p>Vous avez déjà un compte ? <a href="connexion.php">Connectez-vous ici</a>.</p>
</form>

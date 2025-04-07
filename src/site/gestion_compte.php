<?php include('partiels/navbar_adminweb.php'); ?>

<?php
require_once('fonctions.php');

// Connexion à la base de données
$cnx = mysqli_connect('localhost', 'root', 'root', 'sigmax');
if (!$cnx) {
    die("Échec de connexion à la base de données : " . mysqli_connect_error());
}

$responseMessage = ""; // Pour afficher les messages dans le bon formulaire
$formSubmitted = ""; // Variable pour déterminer quel formulaire a été soumis

// Récupération de la clé RC4 depuis la base de données
$key_query = "SELECT cle_rc4 FROM cle LIMIT 1";
$key_result = mysqli_query($cnx, $key_query);
$key_row = mysqli_fetch_assoc($key_result);
$key = $key_row['cle_rc4'];

// Traitement de l'import JSON
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['json_file'])) {
    $fileTmpPath = $_FILES['json_file']['tmp_name'];
    $jsonContent = file_get_contents($fileTmpPath);
    $utilisateurs = json_decode($jsonContent, true);
    $formSubmitted = "json"; // Déterminer quel formulaire a été soumis

    if ($utilisateurs === null) {
        $responseMessage = "<p style='color:red;'>Erreur : le fichier JSON est invalide.</p>";
    } else {
        foreach ($utilisateurs as $user) {
            // Vérification des clés avant d'y accéder
            if (isset($user['login']) && isset($user['password'])) {
                $login = mysqli_real_escape_string($cnx, $user['login']);
                $password = mysqli_real_escape_string($cnx, $user['password']);
                $hashed_password = bin2hex(rc4($key, $password)); // Chiffrement du mot de passe avec RC4

                // Vérification si l'utilisateur existe déjà
                $check_query = "SELECT * FROM users WHERE login = '$login'";
                $check_result = mysqli_query($cnx, $check_query);

                if (mysqli_num_rows($check_result) > 0) {
                    $responseMessage = "<p style='color:red;'>Erreur : L'utilisateur '$login' existe déjà.</p>";
                } else {
                    $query = "INSERT INTO users (login, password) VALUES ('$login', '$hashed_password')";
                    mysqli_query($cnx, $query);
                    $responseMessage = "<p style='color:green;'>Utilisateur '$login' ajouté avec succès !</p>";
                }
            }
        }
    }
}

// Traitement du formulaire manuel
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'], $_POST['password']) && !isset($_FILES['json_file'])) {
    $login = mysqli_real_escape_string($cnx, $_POST['login']);
    $password = mysqli_real_escape_string($cnx, $_POST['password']);
    $hashed_password = bin2hex(rc4($key, $password)); // Chiffrement du mot de passe avec RC4
    $formSubmitted = "manual"; // Déterminer quel formulaire a été soumis

    // Vérification si l'utilisateur existe déjà
    $check_query = "SELECT * FROM users WHERE login = '$login'";
    $check_result = mysqli_query($cnx, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $responseMessage = "<p style='color:red;'>Erreur : L'utilisateur '$login' existe déjà.</p>";
    } else {
        $query = "INSERT INTO users (login, password) VALUES ('$login', '$hashed_password')";
        if (mysqli_query($cnx, $query)) {
            $responseMessage = "<p style='color:green;'>Compte pour '$login' créé avec succès dans la base de données !</p>";
        } else {
            $responseMessage = "<p style='color:red;'>Erreur pour '$login' : " . mysqli_error($cnx) . "</p>";
        }
    }
}

mysqli_close($cnx);
?>

<!-----------------------------------------FORMULAIRE-------------------------------------------------------->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des utilisateurs</title>
</head>
<body>
<main role="main">

    <!-- Formulaire pour ajouter un utilisateur -->
    <div class="form-container-parent">
        <div class="form-container-admin">
            <h1>Ajouter un utilisateur</h1>
            <form action="gestion_compte.php" method="POST">
                <label for="login">Login:</label>
                <input type="text" id="login" name="login" required><br><br>

                <label for="password">Mot de passe:</label>
                <input type="password" id="password" name="password" required><br><br>

                <input type="submit" value="Ajouter utilisateur">
            </form>
            <br><br>
            <?php
            // Afficher le message uniquement si le formulaire d'ajout manuel a été soumis
            if ($formSubmitted == "manual" && !empty($responseMessage)) {
                echo "<div id='importMessage'>$responseMessage</div>";
            }
            ?>
        </div>
    </div>

    <!-- Formulaire pour importer des utilisateurs depuis un fichier JSON -->
    <div class="form-container-parent">
        <div class="form-container-admin">
            <h1>Importer utilisateurs (JSON)</h1>
            <form action="gestion_compte.php" method="POST" enctype="multipart/form-data">
                <label for="json_file">Fichier JSON :</label>
                <input type="file" name="json_file" id="json_file" accept=".json" required><br><br>
                <input type="submit" value="Importer">
            </form>
            <br><br>
            <?php
            // Afficher le message uniquement si le formulaire d'importation JSON a été soumis
            if ($formSubmitted == "json" && !empty($responseMessage)) {
                echo "<div id='importMessage'>$responseMessage</div>";
            }
            ?>
            <br>
        </div>
    </div>

    <?php
    // Si le message a été généré, on ajoute un petit script JS pour scroll automatiquement
    if (!empty($responseMessage)) {
        echo "
    <script>
        window.onload = function() {
            const message = document.getElementById('importMessage');
            if (message) {
                message.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        };
    </script>
    ";
    }
    ?>

</main>

<!-- Inclure le pied de page après le formulaire -->
<?php include('partiels/footer.php'); ?>
</body>
</html>

<!----------------------------- STYLE INCLUT -------------------------------- -->
<style>
    .form-container-admin {
        text-align: center;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #f9f9f9;
        width: 465px;
    }

    h1 {
        font-size: 2rem;
        color: #007bff;
        margin-bottom: 20px;
        text-align: center;
    }

    /* Style du formulaire */
    form {
        background-color: white;
        border-radius: 8px;
        padding: 30px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
    }

    /* Labels des champs */
    label {
        font-size: 1rem;
        margin-bottom: 8px;
        display: block;
        color: #333;
    }

    /* Champs de saisie */
    input[type="text"], input[type="password"] {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 1rem;
    }

    /* Bouton de soumission */
    input[type="submit"] {
        width: 100%;
        padding: 10px;
        background-color: #0a4482;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 1.1rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    /* Effet au survol du bouton */
    input[type="submit"]:hover {
        background-color: #0056b3;
    }

    /* Messages d'erreur et de succès */
    p {
        text-align: center;
        font-size: 1rem;
    }

    p[style*="color:green;"] {
        color: green;
    }

    p[style*="color:red;"] {
        color: red;
    }

    /* Footer fixé en bas */
    footer {
        position: fixed;
        bottom: 0;
        width: 100%;
        text-align: center;
        background-color: #333;
        color: white;
        padding: 10px;
    }
</style>

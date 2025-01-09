<?php include('partiels/navbar_adminweb.php'); ?>
<?php
// Connexion à la base de données
$cnx = mysqli_connect('localhost', 'root', 'root', 'sigmax');

// Vérification de la connexion
if (!$cnx) {
    die("Échec de connexion à la base de données : " . mysqli_connect_error());
}

// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les valeurs du formulaire
    $login = mysqli_real_escape_string($cnx, $_POST['login']);
    $password = mysqli_real_escape_string($cnx, $_POST['password']);

    // Hash du mot de passe pour la base de données
    $hashed_password = md5($password); // PEUT ETRE IL faut essayer : password_hash()

    // 1. Ajouter l'utilisateur dans la base de données
    $query = "INSERT INTO users (login, password) VALUES ('$login', '$hashed_password')";
    if (mysqli_query($cnx, $query)) {
        echo "<p style='color:green;'>Compte pour '$login' créé avec succès dans la base de données !</p>";
    } else {
        echo "<p style='color:red;'>Erreur pour '$login' : " . mysqli_error($cnx) . "</p>";
    }

    // 2. Ajouter l'utilisateur dans le fichier CSV
    $csv_file = 'creer_utilisateurs.csv';
    $file_handle = fopen($csv_file, 'a'); // Ouvrir le fichier CSV en mode ajout

    if ($file_handle !== FALSE) {
        // Écrire les données dans le CSV
        fputcsv($file_handle, array($login, $password)); // Écrire le login et le mot de passe
        fclose($file_handle);
        echo "<p style='color:green;'>Compte pour '$login' ajouté au fichier CSV !</p>";
    } else {
        echo "<p style='color:red;'>Erreur lors de l'ajout dans le fichier CSV.</p>";
    }
}

// Fermeture de la connexion à la base de données
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
<h1>Ajouter un nouvel utilisateur</h1>

<!-- Formulaire pour ajouter un utilisateur -->
<div class="form-container">
<form action="gestion_compte.php" method="POST">
    <label for="login">Login:</label>
    <input type="text" id="login" name="login" required><br><br>

    <label for="password">Mot de passe:</label>
    <input type="password" id="password" name="password" required><br><br>

    <input type="submit" value="Ajouter utilisateur">
</form>
</div>

<!-- Inclure le pied de page après le formulaire -->
<?php include('partiels/footer.php'); ?>
</body>
</html>





<!----------------------------- STYLE INCLUT -------------------------------- -->
<style>
    /* Reset default styles */
    body, html {
        margin: 0;
        padding: 0;
        font-family: 'Arial', sans-serif;
        background-color: #f4f7fc;
        display: flex;
        flex-direction: column;
        height: 100%;
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

    .form-container { 
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
        background-color: #007bff;
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

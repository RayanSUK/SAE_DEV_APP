<?php
// Démarrer la session pour pouvoir utiliser les variables de session
session_start();

// Vérifier s'il y a un message dans la session
if (isset($_SESSION['message'])) {
    // Afficher le message (en le sécurisant)
    echo "<p style='color:green;'>" . htmlspecialchars($_SESSION['message']) . "</p>";

    // Effacer le message après l'affichage
    unset($_SESSION['message']);
}
// Connexion à la base de données
$cnx = mysqli_connect('localhost', 'root', 'root', 'sigmax');

// Vérification de la connexion
if (!$cnx) {
    die("Échec de connexion à la base de données : " . mysqli_connect_error());
}

// Fonction pour récupérer les utilisateurs inscrits
function getUtilisateurs() {
    global $cnx; // Utilisation de la connexion globale
    $query = "SELECT * FROM users WHERE login NOT IN (SELECT login FROM users WHERE login='adminweb' or login='adminsys');";
; // La requête SQL
    $result = mysqli_query($cnx, $query); // Exécution de la requête

    if ($result) {
        // Si la requête réussie, récupérer les résultats
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        // Si la requête échoue, afficher l'erreur
        echo "Erreur dans la requête : " . mysqli_error($cnx);
        return [];
    }
}

// Appel de la fonction pour récupérer les utilisateurs
$utilisateurs = getUtilisateurs();
?>

<?php include('partiels/navbar_adminweb.php'); ?>

<?php
if (isset($_SESSION['message'])) {
    // Afficher le message
    echo "<p style='color:green;'>" . htmlspecialchars($_SESSION['message']) . "</p>";

    // Effacer le message après l'affichage
    unset($_SESSION['message']);
}
?>

<!-- --------------------------------------------------------------------Contenu de la page des utilisateurs inscrits ------------------------------------>
<main role="main">
<div class="text-center">
<h1>Liste des utilisateurs inscrits</h1>
</div>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Login</th>
        <th>Action</th>
    </tr>
    <?php foreach ($utilisateurs as $utilisateur): ?>
        <tr>
            <td><?php echo htmlspecialchars($utilisateur['id']); ?></td>
            <td><?php echo htmlspecialchars($utilisateur['login']); ?></td>
            <td>
                <!-- Formulaire pour supprimer l'utilisateur -->
                <form action="supprimer_utilisateurs.php" method="POST" style="display:inline;">
                    <input type="hidden" name="login" value="<?php echo htmlspecialchars($utilisateur['login']); ?>">
                    <input type="submit" name="delete_user" value="Supprimer utilisateur">
                </form>

                <!-- Formulaire pour supprimer l'historique de l'utilisateur -->
                <form action="supprimer_utilisateurs.php" method="POST" style="display:inline;">
                    <input type="hidden" name="login" value="<?php echo htmlspecialchars($utilisateur['login']); ?>">
                    <input type="submit" name="delete_history" value="Supprimer historique">
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
</main>
<?php include('partiels/footer.php'); ?>

<?php
// Fermeture de la connexion à la base de données
mysqli_close($cnx);
?>


<!--------------------------------------------------------------------------STYLE ------------------------------------------------------------------------------------------------------------->
<style>

    



    /* Titre de la page */
    h1 {
        font-size: 2.5rem;
        color: #007bff;
        margin-bottom: 20px;
    }

    /* Style du tableau */
    table {
        width: 80%;
        margin: 20px auto;
        border-collapse: collapse;
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    th, td {
        padding: 10px;
        text-align: left;
        border: 1px solid #ddd;
    }

    th {
        background-color: #0a4482;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    td form {
        margin-right: 10px;
    }

    /* Boutons */
    input[type="submit"] {
        background-color: #0a4482;
        color: white;
        border: none;
        padding: 8px 16px;
        cursor: pointer;
        border-radius: 5px;
    }

    input[type="submit"]:hover {
        background-color: #0056b3;
    }

    /* Footer fixe en bas */
    footer {
        text-align: center;
        padding: 20px;
        background-color: #333;
        color: #fff;
        margin-top: auto;
    }
</style>

</body>
</html>

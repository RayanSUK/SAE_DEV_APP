<?php include('partiels/navbar_adminsys.php'); ?>

<?php
$cnx = mysqli_connect('localhost', 'root', 'root', 'sigmax');
if (!$cnx) {
    die("Échec de connexion à la base de données : " . mysqli_connect_error());
}

// Récupération des filtres s'ils existent
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';


// Construction de la requête SQL pour afficher les logs filtrés si nécessaire
if (!empty($start_date) && !empty($end_date)) {
    $query = "SELECT * FROM adminsysteme WHERE jour >= '$start_date' AND jour <= '$end_date' ORDER BY jour DESC, heure DESC";
} else {
    $query = "SELECT * FROM adminsysteme ORDER BY jour DESC, heure DESC";
}

$result = mysqli_query($cnx, $query);
$logs = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style2.css">
    <title>Journal d'activités</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>


    </style>
</head>
<body>
    <div class="container2">
        <div class="left">
            <br>
            <h2>Journal d'activités</h2>
            <br>
            <div id="logTableContainer">
                <?php if (empty($logs)) : ?>
                    <p>Aucune activité à cette date</p>
                <?php else : ?>
                    <table border="1">
                        <thead>
                            <tr>
                                <th>Jour</th>
                                <th>Heure</th>
                                <th>IP</th>
                                <th>Login</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($logs as $log) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($log['jour']) ?></td>
                                    <td><?= htmlspecialchars($log['heure']) ?></td>
                                    <td><?= htmlspecialchars($log['ip']) ?></td>
                                    <td><?= htmlspecialchars($log['login']) ?></td>
                                    <td><?= htmlspecialchars($log['statut']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>

        <?php $today = date('Y-m-d'); ?>

        <div class="right">
            <br><br>
            <!-- Formulaire de filtrage -->
            <form id="filterForm" method="POST" action="">
                <h3>Filtrer par Date</h3>
                <br>
                <label for="start_date">Date de début :</label><br>
                <input type="date" id="start_date" name="start_date" value="<?= isset($start_date) && $start_date ? htmlspecialchars($start_date) : $today ?>">
                <br><br>
                <label for="end_date">Date de fin :</label><br>
                <input type="date" id="end_date" name="end_date" value="<?= isset($end_date) && $end_date ? htmlspecialchars($end_date) : $today ?>">
                <br><br>
                <button type="submit">Filtrer l'affichage</button>
                <br>
                <a href="journal.php"><button type="button">Enlever les filtres</button></a>
            </form>

            <!-- Message de retour de suppression -->
            <?php if (isset($message)) : ?>
                <div id="message"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>

            <!-- Formulaire d'actions -->
             <br>
            <form id="actionForm">
                <h3>Exportation et Suppression</h3>
                <br>
                <label for="action_start">Date de début :</label>
                <input type="date" id="action_start" name="action_start" value="<?= $today ?>">
                <br>
                <label for="action_end">Date de fin :</label>
                <input type="date" id="action_end" name="action_end" value="<?= $today ?>">
                <br><br>
                <button type="button" id="downloadAll">Exporter tous les logs</button>
                <br>
                <button type="button" id="downloadFiltered">Exporter les logs <br> (sur la période définie)</button>
                <br>
                <button type="" id="deleteAll">Supprimer tous les logs</button>
                <br>
                <button type="submit" id="deleteFiltered">Supprimer les logs <br>(sur la période définie)</button>
                <br><br>
                <label for="jsonFile">Choisir un journal d'activités à afficher (.json) :</label><br>
                <input type="file" id="jsonFile" accept=".json">
                <br><br>
                <button type="button" id="showJson">Afficher le contenu du fichier</button>


            </form>
        </div>
    </div>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Fonction pour télécharger les logs sous forme de fichier JSON
        function downloadLogs(logs, filename) {
            const blob = new Blob([JSON.stringify(logs, null, 2)], { type: 'application/json' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = filename;
            link.click();
        }

        // Télécharger tous les logs
        document.getElementById("downloadAll").addEventListener("click", function() {
        fetchLogs('downloadAll', null, null);
    });

    // Télécharger les logs filtrés (sur la période définie)
    document.getElementById("downloadFiltered").addEventListener("click", function() {
        const start_date = document.getElementById("action_start").value;
        const end_date = document.getElementById("action_end").value;

        // Vérification de la validité des dates
        if (start_date && end_date) {
            if (start_date > end_date) {
                alert("La date de début ne peut pas être supérieure à la date de fin.");
                return; // Bloquer la suppression si la condition n'est pas remplie
            } else {
                // Appel de la fonction pour récupérer les logs filtrés
                fetchLogs('downloadFiltered', start_date, end_date);
            }
        }
    });

    // Fonction pour récupérer les logs via fetch et télécharger en JSON
    function fetchLogs(action, start_date, end_date) {
        const params = new URLSearchParams();
        params.append('action', action);
        if (start_date) params.append('start_date', start_date);
        if (end_date) params.append('end_date', end_date);

        fetch('actions.php', {
            method: 'POST',
            body: params
        })
        .then(response => response.json())
        .then(data => {
            if (data && data.length > 0) {
                // Si c'est pour tous les logs
                const filename = action === 'downloadAll' ? 'logs_complets.json' : `logs_${start_date}_to_${end_date}.json`;
                downloadLogs(data, filename);
            } else {
                alert('Aucun log à télécharger pour cette période.');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur est survenue.');
        });
    }



    // Suppression de tous les logs
    document.getElementById("deleteAll").addEventListener("click", function() {
        if (confirm("Êtes-vous sûr de vouloir supprimer tous les logs ?")) {
            fetch('actions.php', {
                method: 'POST',
                body: new URLSearchParams({ 'action': 'deleteAll' })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById("message").innerText = "Logs supprimés avec succès";
                    setTimeout(() => {
                        location.reload(); // Recharger la page pour voir les changements
                    }, 2000); // Attendre 2 secondes avant de recharger
                } else {
                    document.getElementById("message").innerText = "Une erreur est survenue lors de la suppression.";
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                document.getElementById("message").innerText = "Une erreur est survenue lors de la suppression.";
            });
        }
    });

    // Suppression des logs filtrés par période
    document.getElementById("deleteFiltered").addEventListener("click", function() {
        const start_date = document.getElementById("action_start").value;
        const end_date = document.getElementById("action_end").value;

        // Vérification de la validité des dates
        if (start_date && end_date) {
            if (start_date > end_date) {
                alert("La date de début ne peut pas être supérieure à la date de fin.");
                return; // Bloquer la suppression si la condition n'est pas remplie
            }
            
            if (confirm(`Êtes-vous sûr de vouloir supprimer les logs entre ${start_date} et ${end_date} ?`)) {
                fetch('actions.php', {
                    method: 'POST',
                    body: new URLSearchParams({
                        'action': 'deleteFiltered',
                        'start_date': start_date,
                        'end_date': end_date
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById("message").innerText = "Logs supprimés avec succès";
                        setTimeout(() => {
                            location.reload(); // Recharger la page pour voir les changements
                        }, 2000); // Attendre 2 secondes avant de recharger
                    } else {
                        document.getElementById("message").innerText = "Une erreur est survenue lors de la suppression.";
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    document.getElementById("message").innerText = "Une erreur est survenue lors de la suppression.";
                });
            }
        } else {
            alert("Veuillez spécifier une période.");
        }
    });
        // Vérification de la validité des dates dans le formulaire de filtrage (paramètres d'affichage)
        document.getElementById("filterForm").addEventListener("submit", function(event) {
        const start_date = document.getElementById("start_date").value;
        const end_date = document.getElementById("end_date").value;

        if (start_date && end_date) {
            if (start_date > end_date) {
                alert("La date de début ne peut pas être supérieure à la date de fin.");
                event.preventDefault(); // Empêche la soumission du formulaire si les dates sont invalides
            }
        }
    });
});

document.getElementById("showJson").addEventListener("click", function () {
    const fileInput = document.getElementById("jsonFile");
    const file = fileInput.files[0];

    if (!file) {
        alert("Veuillez sélectionner un fichier JSON.");
        return;
    }

    const reader = new FileReader();

    reader.onload = function (e) {
        try {
            const jsonContent = JSON.parse(e.target.result);
            // Affiche le JSON complet dans une vraie fenêtre modale
            showJsonModal(JSON.stringify(jsonContent, null, 2));
        } catch (error) {
            alert("Le fichier n'est pas un JSON valide.");
        }
    };

    reader.readAsText(file);
});

function showJsonModal(content) {
    document.getElementById("jsonContent").textContent = content;
    document.getElementById("jsonModal").style.display = "block";
}


</script>
<div id="jsonModal" style="display: none; position: fixed; top: 10%; left: 10%; width: 80%; height: 80%; background: white; border: 2px solid #444; border-radius: 8px; box-shadow: 0 0 20px rgba(0,0,0,0.4); padding: 20px; overflow-y: auto; z-index: 1000;">
    <button class="close-btn" onclick="document.getElementById('jsonModal').style.display='none'" style="float: right;">Fermer</button>
    <pre id="jsonContent" style="white-space: pre-wrap; word-break: break-word;"></pre>
</div>

</body>
<br><br><br>
<?php include('partiels/footer.php'); ?>
</html>



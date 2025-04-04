<?php
$cnx = mysqli_connect('localhost', 'root', 'root', 'sigmax');
if (!$cnx) {
    die("Échec de connexion à la base de données : " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    try {
        // Vérifier l'action demandée
        if ($action === 'deleteAll') {
            $query = "DELETE FROM adminsysteme";
            $result = mysqli_query($cnx, $query);

            if ($result) {
                echo "Activité(s) supprimée(s) !"; // Message de succès
            } else {
                throw new Exception('Erreur lors de la suppression de toutes les activités.');
            }
        } elseif ($action === 'deleteFiltered') {
            $start_date = $_POST['start_date'] ?? '';
            $end_date = $_POST['end_date'] ?? '';

            if (empty($start_date) || empty($end_date)) {
                throw new Exception('Les dates de début et de fin sont nécessaires.');
            }

            $query = "DELETE FROM adminsysteme WHERE jour >= '$start_date' AND jour <= '$end_date'";
            $result = mysqli_query($cnx, $query);

            if ($result) {
                echo "Activité(s) du $start_date à $end_date supprimée(s) !"; // Message de succès
            } else {
                throw new Exception('Erreur lors de la suppression des activités dans la période spécifiée.');
            }
        } elseif ($action === 'downloadAll' || $action === 'downloadFiltered') {
            $start_date = $_POST['start_date'] ?? '';
            $end_date = $_POST['end_date'] ?? '';
        
            $query = ($action === 'downloadAll') ?
                "SELECT * FROM adminsysteme" :
                "SELECT * FROM adminsysteme WHERE jour >= '$start_date' AND jour <= '$end_date'";
        
            $result = mysqli_query($cnx, $query);
        
            if ($result) {
                $logs = [];
                while ($row = mysqli_fetch_assoc($result)) {
                    $logs[] = $row;
                }
                header('Content-Type: application/json');
                echo json_encode($logs);
            } else {
                throw new Exception('Erreur lors de la récupération des logs.');
            }
        }
         else {
            throw new Exception('Action non reconnue.');
        }
    } catch (Exception $e) {
        echo 'Erreur: ' . $e->getMessage(); // En cas d'erreur, afficher un message d'erreur
    }
}
?>
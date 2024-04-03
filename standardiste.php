<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('tables.php');

if (!isset($_SESSION['user']) || $_SESSION['user']['TypeCompte'] != 'Standardiste') {
    header('Location: index.php');
    exit();
}

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données : " . $conn->connect_error);
}

$sqlIntervention = "SELECT * FROM Intervention";
$resultIntervention = $conn->query($sqlIntervention);
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="assets/logo.svg">
    <title>Standardiste - Accord Energie</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
</head>
<body>
    <h1>Tableau des tickets</h1>
    <table id="intervention" class="display" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Date création</th>
                <th>Statut</th>
                <th>Degré urgence</th>
                <th>Commentaire</th>
                <th>ClientID</th>
                <th>Type de problème</th>
                <th>Date intervention</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $resultIntervention->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["InterventionID"] . "</td>";
                echo "<td>" . $row["Date"] . "</td>";
                echo "<td>" . $row["Statut"] . "</td>";
                echo "<td>" . $row["DegreUrgence"] . "</td>";
                echo "<td>" . $row["Commentaire"] . "</td>";
                echo "<td>" . $row["ClientID"] . "</td>";
                echo "<td>" . $row["TypeDeProbleme"] . "</td>";
                echo "<td>" . $row["DateIntervention"] . "</td>";
                echo "<td>";
                echo "<a href='modifier-ticket.php?id=" . $row["InterventionID"] . "'>Modifier</a> | ";
                echo "<a href='assigner-intervenant.php?id=" . $row["InterventionID"] . "'>Assigner un intervenant</a>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <script>
        $(document).ready(function() {
            $('#intervention').DataTable();
        } );
    </script>
</body>
</html>

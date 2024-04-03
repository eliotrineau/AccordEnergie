<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('tables.php');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "AccordEnergie";

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Échec de la connexion à la base de données : " . $conn->connect_error);
}

$conn->select_db($dbname);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $typeDeProbleme = $_POST['typeDeProbleme'];
    $dateIntervention = $_POST['dateIntervention'];
    $commentaire = $_POST['commentaire'];
    $clientID = $_POST['clientID'];

    $sql = "SELECT ClientID FROM Client WHERE UserID = '$clientID'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $clientID = $result->fetch_assoc()['ClientID'];

        $sql = "INSERT INTO Intervention (Date, Statut, DegreUrgence, TypeDeProbleme, DateIntervention, Commentaire, ClientID)
                VALUES (NOW(), 'En Attente', 'Faible', '$typeDeProbleme', '$dateIntervention', '$commentaire', '$clientID')";
        $result = $conn->query($sql);

        if ($result) {
            $interventionID = $conn->insert_id;

            $sql = "SELECT StandardisteID FROM Standardiste ORDER BY RAND() LIMIT 1";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $standardisteID = $result->fetch_assoc()['StandardisteID'];

                $sql = "INSERT INTO Gerer (StandardisteID, InterventionID) VALUES ($standardisteID, $interventionID)";
                $result = $conn->query($sql);

                if ($result) {
                    header("Location: interface.php");
                } else {
                    echo "Erreur lors de l'ajout de l'entrée dans la table Gerer : " . $conn->error;
                }
            } else {
                echo "Aucun standardiste disponible";
            }
        } else {
            echo "Erreur lors de la création du ticket : " . $conn->error;
        }
    } else {
        echo "L'utilisateur spécifié n'est pas un client";
    }
} else {
    echo "Requête invalide";
}

$conn->close();
?>
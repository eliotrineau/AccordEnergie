<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('tables.php');

if (!isset($_SESSION['user']) || $_SESSION['user']['TypeCompte'] != 'Admin') {
    header('Location: index.php');
    exit();
}

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données : " . $conn->connect_error);
}

$intervention_id = $_GET['id'];

$sql = "DELETE FROM Effectuer WHERE InterventionID = $intervention_id";
$conn->query($sql);

$sql = "DELETE FROM Gerer WHERE InterventionID = $intervention_id";
$conn->query($sql);

// Supprimer l'intervention
$sql = "DELETE FROM Intervention WHERE InterventionID = $intervention_id";
$conn->query($sql);

header('Location: admin.php');
exit();
?>

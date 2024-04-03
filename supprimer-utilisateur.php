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

$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($user_id <= 0) {
    header('Location: admin.php');
    exit();
}

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données : " . $conn->connect_error);
}

$sql = "DELETE FROM Intervention WHERE ClientID IN (SELECT ClientID FROM Client WHERE UserID = $user_id)";
$conn->query($sql);

$sql = "DELETE FROM Client WHERE UserID = $user_id";
$conn->query($sql);

$sql = "DELETE FROM Utilisateur WHERE UserID = $user_id";
$conn->query($sql);

header('Location: admin.php');
exit();
?>

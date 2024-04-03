<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "AccordEnergie";

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Échec de la connexion à la base de données : " . $conn->connect_error);
}


$conn->select_db($dbname);
?>

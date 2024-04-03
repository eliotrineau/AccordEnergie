<?php
include('db.php');

$intervention_id = $_POST['intervention_id'];
$statut = $_POST['statut'];

$sql = "UPDATE Intervention SET Statut = ? WHERE InterventionID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $statut, $intervention_id);
$stmt->execute();

header('Location: intervenant.php');
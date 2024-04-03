<?php
include('db.php');

$intervention_id = $_POST['intervention_id'];
$commentaire = $_POST['commentaire'];

$sql = "UPDATE Intervention SET Commentaire = ? WHERE InterventionID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $commentaire, $intervention_id);
$stmt->execute();

header('Location: intervenant.php');
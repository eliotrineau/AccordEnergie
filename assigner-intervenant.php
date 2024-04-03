<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('tables.php');

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données : " . $conn->connect_error);
}

$intervention_id = $_GET['id'];

$sqlIntervenant = "SELECT * FROM Intervenant INNER JOIN Utilisateur ON Intervenant.UserID = Utilisateur.UserID";
$resultIntervenant = $conn->query($sqlIntervenant);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $intervenant_id = $_POST['intervenant'];

    $sql = "INSERT INTO Effectuer (IntervenantID, InterventionID) VALUES ($intervenant_id, $intervention_id)";

    if ($conn->query($sql) === TRUE) {
        header('Location: ' . ($_SESSION['user']['TypeCompte'] === 'Admin' ? 'admin.php' : 'standardiste.php'));
        exit();
    } else {
        echo "Error assigning intervenant: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assigner un intervenant - Accord Energie</title>
</head>
<body>
    <h1>Assigner un intervenant</h1>
    <form action="assigner-intervenant.php?id=<?php echo $intervention_id; ?>" method="post">
        <div>
            <label for="intervenant">Intervenant :</label>
            <select name="intervenant" id="intervenant">
                <?php
                while ($row = $resultIntervenant->fetch_assoc()) {
                    echo "<option value=\"{$row['IntervenantID']}\">{$row['Nom']} {$row['Prenom']}</option>";
                }
                ?>
            </select>
        </div>
        <div>
            <button type="submit">Assigner</button>
        </div>
    </form>
</body>
</html>

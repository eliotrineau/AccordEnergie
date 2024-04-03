<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('tables.php');

if (!isset($_SESSION['user']) || $_SESSION['user']['TypeCompte'] === 'Client' || $_SESSION['user']['TypeCompte'] === 'Intervenant') {
    header('Location: index.php');
    exit();
}

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données : " . $conn->connect_error);
}

$intervention_id = $_GET['id'];

$sql = "SELECT * FROM Intervention WHERE InterventionID = $intervention_id";
$result = $conn->query($sql);

$intervention = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $statut = $_POST['statut'];
    $degre_urgence = $_POST['degre_urgence'];
    $commentaire = $_POST['commentaire'];
    $client_id = $_POST['client_id'];
    $type_probleme = $_POST['type_probleme'];
    $date_intervention = $_POST['date_intervention'];

    $sql = "UPDATE Intervention SET Date = '$date', Statut = '$statut', DegreUrgence = '$degre_urgence', Commentaire = '$commentaire', ClientID = '$client_id', TypeDeProbleme = '$type_probleme', DateIntervention = '$date_intervention' WHERE InterventionID = $intervention_id";

    if ($conn->query($sql) === TRUE) {
        header('Location: admin.php');
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Ticket - Accord Energie</title>
</head>
<body>
    <h1>Modifier Ticket</h1>
    <form action="modifier-ticket.php?id=<?php echo $intervention_id; ?>" method="post">
        <label for="date">Date création:</label>
        <input type="date" id="date" name="date" value="<?php echo $intervention['Date']; ?>"><br><br>

        <label for="statut">Statut:</label>
        <select id="statut" name="statut">
            <option value="En Attente" <?php if ($intervention['Statut'] == 'En Attente') echo 'selected'; ?>>En Attente</option>
            <option value="En Cours" <?php if ($intervention['Statut'] == 'En Cours') echo 'selected'; ?>>En Cours</option>
            <option value="Terminee" <?php if ($intervention['Statut'] == 'Terminee') echo 'selected'; ?>>Terminée</option>
            <option value="Annulee" <?php if ($intervention['Statut'] == 'Annulee') echo 'selected'; ?>>Annulée</option>
            <option value="Cloturee" <?php if ($intervention['Statut'] == 'Cloturee') echo 'selected'; ?>>Clôturée</option>
        </select><br><br>

        <label for="degre_urgence">Degré urgence:</label>
        <select id="degre_urgence" name="degre_urgence">
            <option value="Faible" <?php if ($intervention['DegreUrgence'] == 'Faible') echo 'selected'; ?>>Faible</option>
            <option value="Moyen" <?php if ($intervention['DegreUrgence'] == 'Moyen') echo 'selected'; ?>>Moyen</option>
            <option value="Eleve" <?php if ($intervention['DegreUrgence'] == 'Eleve') echo 'selected'; ?>>Élevé</option>
        </select><br><br>

        <label for="commentaire">Commentaire:</label>
        <textarea id="commentaire" name="commentaire"><?php echo $intervention['Commentaire']; ?></textarea><br><br>

        <label for="client_id">ClientID:</label>
        <input type="text" id="client_id" name="client_id" value="<?php echo $intervention['ClientID']; ?>"><br><br>

        <label for="type_probleme">Type de problème:</label>
        <select id="type_probleme" name="type_probleme">
            <option value="Panne" <?php if ($intervention['TypeDeProbleme'] == 'Panne') echo 'selected'; ?>>Panne</option>
            <option value="Facture" <?php if ($intervention['TypeDeProbleme'] == 'Facture') echo 'selected'; ?>>Facture</option>
            <option value="Autres" <?php if ($intervention['TypeDeProbleme'] == 'Autres') echo 'selected'; ?>>Autres</option>
        </select><br><br>

        <label for="date_intervention">Date intervention:</label>
        <input type="date" id="date_intervention" name="date_intervention" value="<?php echo $intervention['DateIntervention']; ?>"><br><br>

        <input type="submit" value="Modifier">
    </form>
</body>
</html>
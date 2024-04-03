<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('db.php');

if (!isset($_SESSION['user']) || $_SESSION['user']['TypeCompte'] != 'Intervenant') {
    header('Location: index.php');
    exit();
}

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données : " . $conn->connect_error);
}

$sql = "SELECT i.*, u.Adresse, u.Telephone FROM Intervention i JOIN Client c ON i.ClientID = c.ClientID JOIN Utilisateur u ON c.UserID = u.UserID";

$stmt = $conn->prepare($sql);
$stmt->execute();

$result = $stmt->get_result();
$interventions = $result->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intervenant - Accord Energie</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</head>
<body>
    <h1>Liste des interventions</h1>
    <table id="interventionsintervenant" class="display" style="width:100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Client ID</th>
            <th>Date</th>
            <th>Statut</th>
            <th>Degré d'urgence</th>
            <th>Type de problème</th>
            <th>Date d'intervention</th>
            <th>Commentaire</th>
            <th>Adresse</th>
            <th>Téléphone</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($interventions as $intervention) : ?>
    <tr>
        <td><?= htmlspecialchars($intervention['InterventionID']) ?></td>
        <td><?= htmlspecialchars($intervention['ClientID']) ?></td>
        <td><?= htmlspecialchars($intervention['Date']) ?></td>
        <td>
            <form action="modifier-statut.php" method="post">
                <input type="hidden" name="intervention_id" value="<?= htmlspecialchars($intervention['InterventionID']) ?>">
                <select name="statut">
                    <option value="En Attente" <?= ($intervention['Statut'] == 'En Attente') ? 'selected' : '' ?>>En Attente</option>
                    <option value="En Cours" <?= ($intervention['Statut'] == 'En Cours') ? 'selected' : '' ?>>En Cours</option>
                    <option value="Terminee" <?= ($intervention['Statut'] == 'Terminee') ? 'selected' : '' ?>>Terminée</option>
                    <option value="Annulee" <?= ($intervention['Statut'] == 'Annulee') ? 'selected' : '' ?>>Annulée</option>
                    <option value="Cloturee" <?= ($intervention['Statut'] == 'Cloturee') ? 'selected' : '' ?>>Clôturée</option>
                </select>
                <input type="submit" value="Modifier">
            </form>
        </td>
        <td><?= htmlspecialchars($intervention['DegreUrgence']) ?></td>
        <td><?= htmlspecialchars($intervention['TypeDeProbleme']) ?></td>
        <td><?= htmlspecialchars($intervention['DateIntervention']) ?></td>
        <td>
            <form action="modifier-commentaire.php" method="post">
                <input type="hidden" name="intervention_id" value="<?= htmlspecialchars($intervention['InterventionID']) ?>">
                <textarea name="commentaire"><?= htmlspecialchars($intervention['Commentaire']) ?></textarea>
                <input type="submit" value="Modifier">
            </form>
        </td>
        <td><?= htmlspecialchars($intervention['Adresse']) ?></td>
        <td><?= htmlspecialchars($intervention['Telephone']) ?></td>
    </tr>
<?php endforeach; ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#interventionsintervenant').DataTable();
    } );
</script>
</body>
</html>

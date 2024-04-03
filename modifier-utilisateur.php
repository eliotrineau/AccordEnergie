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

$sql = "SELECT * FROM Utilisateur WHERE UserID = $user_id";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $adresse = $_POST['adresse'];
    $type_compte = $_POST['type_compte'];

    $sql = "UPDATE Utilisateur SET Nom = '$nom', Prenom = '$prenom', Email = '$email', Telephone = '$telephone', Adresse = '$adresse', TypeCompte = '$type_compte' WHERE UserID = $user_id";

    $result = $conn->query($sql);

    $sql = "DELETE FROM Standardiste WHERE UserID = $user_id";
    $conn->query($sql);
    $sql = "DELETE FROM Intervenant WHERE UserID = $user_id";
    $conn->query($sql);
    $sql = "DELETE FROM Client WHERE UserID = $user_id";
    $conn->query($sql);

    switch ($type_compte) {
        case 'Standardiste':
            $sql = "INSERT INTO Standardiste (UserID) VALUES ($user_id)";
            $conn->query($sql);
            break;
        case 'Intervenant':
            $sql = "INSERT INTO Intervenant (UserID) VALUES ($user_id)";
            $conn->query($sql);
            break;
        case 'Client':
            $sql = "INSERT INTO Client (UserID) VALUES ($user_id)";
            $conn->query($sql);
            break;
    }

    header('Location: admin.php');
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un utilisateur - Accord Energie</title>
</head>
<body>
    <h1>Modifier un utilisateur</h1>
    <form action="modifier-utilisateur.php?id=<?php echo $user_id; ?>" method="post">
        <div>
            <label for="nom">Nom :</label>
            <input type="text" name="nom" id="nom" value="<?php echo htmlspecialchars($user['Nom']); ?>" required>
        </div>
        <div>
            <label for="prenom">Prénom :</label>
            <input type="text" name="prenom" id="prenom" value="<?php echo htmlspecialchars($user['Prenom']); ?>" required>
        </div>
        <div>
            <label for="email">Email :</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['Email']); ?>" required>
        </div>
        <div>
            <label for="telephone">Téléphone :</label>
            <input type="tel" name="telephone" id="telephone" value="<?php echo htmlspecialchars($user['Telephone']); ?>" required>
        </div>
        <div>
            <label for="adresse">Adresse :</label>
            <input type="text" name="adresse" id="adresse" value="<?php echo htmlspecialchars($user['Adresse']); ?>" required>
        </div>
        <div>
            <label for="type_compte">Type de compte :</label>
            <select name="type_compte" id="type_compte">
                <option value="Admin" <?php if ($user['TypeCompte'] == 'Admin') echo 'selected'; ?>>Admin</option>
                <option value="Standardiste" <?php if ($user['TypeCompte'] == 'Standardiste') echo 'selected'; ?>>Standardiste</option>
                <option value="Intervenant" <?php if ($user['TypeCompte'] == 'Intervenant') echo 'selected'; ?>>Intervenant</option>
                <option value="Client" <?php if ($user['TypeCompte'] == 'Client') echo 'selected'; ?>>Client</option>
            </select>
        </div>
        <div>
            <button type="submit">Enregistrer les modifications</button>
        </div>
    </form>
</body>
</html>

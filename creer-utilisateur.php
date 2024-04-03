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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $email = $_POST["email"];
    $telephone = $_POST["telephone"];
    $adresse = $_POST["adresse"];
    $motDePasse = $_POST["motDePasse"];
    $typeCompte = $_POST["typeCompte"];

    $sql = "INSERT INTO Utilisateur (Nom, Prenom, Email, Telephone, Adresse, MotDePasse, TypeCompte) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $nom, $prenom, $email, $telephone, $adresse, $motDePasse, $typeCompte);
    $stmt->execute();

    header("Location: admin.php");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="assets/logo.svg">
    <title>Créer un nouvel utilisateur - Accord Energie</title>
</head>
<body>
    <h1>Créer un nouvel utilisateur</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="nom">Nom :</label>
        <input type="text" name="nom" required><br>

        <label for="prenom">Prénom :</label>
        <input type="text" name="prenom" required><br>

        <label for="email">Email :</label>
        <input type="email" name="email" required><br>

        <label for="telephone">Téléphone :</label>
        <input type="text" name="telephone" required><br>

        <label for="adresse">Adresse :</label>
        <input type="text" name="adresse" required><br>

        <label for="motDePasse">Mot de passe :</label>
        <input type="password" name="motDePasse" required><br>

        <label for="typeCompte">Type de compte :</label>
        <select name="typeCompte" required>
            <option value="Standardiste">Standardiste</option>
            <option value="Intervenant">Intervenant</option>
            <option value="Client">Client</option>
        </select><br>

        <input type="submit" value="Créer">
    </form>
</body>
</html>

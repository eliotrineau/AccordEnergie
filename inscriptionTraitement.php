<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('tables.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $telephone = $_POST['telephone'];
    $adresse = $_POST['adresse'];
    $motDePasse = $_POST['motDePasse'];
    $motDePasseConfirmation = $_POST['motDePasseConfirmation'];
    $email = $_POST['email'];
    $emailConfirmation = $_POST['emailConfirmation'];

    include('db.php');

    if ($conn->connect_error) {
        die("Échec de la connexion à la base de données : " . $conn->connect_error);
    }

    if ($email === $emailConfirmation) {
        if ($motDePasse === $motDePasseConfirmation) {
            $hashedPassword = password_hash($motDePasse, PASSWORD_DEFAULT);

            $sql = "INSERT INTO Utilisateur (Nom, Prenom, Telephone, Adresse, Email, MotDePasse, TypeCompte)
                    VALUES ('$nom', '$prenom', '$telephone', '$adresse', '$email', '$hashedPassword', 'Client')";

            if ($conn->query($sql) === TRUE) {
                $user_id = $conn->insert_id;

                $sql = "INSERT INTO Client (UserID) VALUES ($user_id)";
                if ($conn->query($sql) === TRUE) {
                    header("Location: connexion.php");
                    exit();
                    $conn->close();
                } else {
                    echo "<script>alert(\"Erreur lors de l'inscription : " . $conn->error . "\")</script>";
                }
            } else {
                echo "<script>alert(\"Erreur lors de l'inscription : " . $conn->error . "\")</script>";
            }
        } else {
            echo "<script>alert(\"Les mots de passe ne correspondent pas\")</script>";
        }
    } else {
        echo "<script>alert(\"Les adresses email ne correspondent pas\")</script>";
    }
}
?>

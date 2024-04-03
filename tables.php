<?php
include('db.php');
?>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "AccordEnergie";

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Échec de la connexion à la base de données : " . $conn->connect_error);
}

/*
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Base de données créée avec succès\n";
} else {
    echo "Erreur lors de la création de la base de données : " . $conn->error;
}
*/


$conn->select_db($dbname);

$sql = "CREATE TABLE IF NOT EXISTS Utilisateur (
    UserID INT AUTO_INCREMENT PRIMARY KEY,
    Nom VARCHAR(50) NOT NULL,
    Prenom VARCHAR(50) NOT NULL,
    Email VARCHAR(100) NOT NULL,
    Telephone VARCHAR(100) NOT NULL,
    Adresse VARCHAR(100) NOT NULL,
    MotDePasse VARCHAR(255) NOT NULL,
    TypeCompte ENUM('Admin', 'Standardiste', 'Intervenant', 'Client') NOT NULL
)";

$conn->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS Client (
    ClientID INT AUTO_INCREMENT PRIMARY KEY,
    UserID INT,
    FOREIGN KEY (UserID) REFERENCES Utilisateur(UserID)
)";

$conn->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS Intervention (
    InterventionID INT AUTO_INCREMENT PRIMARY KEY,
    Date DATE NOT NULL,
    Statut ENUM('En Attente', 'En Cours', 'Terminee', 'Annulee', 'Cloturee') NOT NULL,
    DegreUrgence ENUM('Faible', 'Moyen', 'Eleve') NOT NULL,
    TypeDeProbleme ENUM('Panne', 'Facture', 'Autres'),
    DateIntervention TEXT,
    Commentaire TEXT,
    ClientID INT,
    CONSTRAINT FK_Intervention_Client FOREIGN KEY (ClientID) REFERENCES Client(ClientID)
)";

$conn->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS Intervenant (
    IntervenantID INT AUTO_INCREMENT PRIMARY KEY,
    UserID INT,
    FOREIGN KEY (UserID) REFERENCES Utilisateur(UserID)
)";

$conn->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS Standardiste (
    StandardisteID INT AUTO_INCREMENT PRIMARY KEY,
    UserID INT,
    FOREIGN KEY (UserID) REFERENCES Utilisateur(UserID)
)";

$conn->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS Admin (
    AdminID INT AUTO_INCREMENT PRIMARY KEY,
    UserID INT,
    FOREIGN KEY (UserID) REFERENCES Utilisateur(UserID)
)";

$conn->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS Effectuer (
    IntervenantID INT,
    InterventionID INT,
    PRIMARY KEY (IntervenantID, InterventionID),
    FOREIGN KEY (IntervenantID) REFERENCES Intervenant(IntervenantID),
    FOREIGN KEY (InterventionID) REFERENCES Intervention(InterventionID)
)";

$conn->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS Appartenir (
    ClientID INT,
    InterventionID INT,
    PRIMARY KEY (ClientID, InterventionID),
    FOREIGN KEY (ClientID) REFERENCES Client(ClientID),
    FOREIGN KEY (InterventionID) REFERENCES Intervention(InterventionID)
)";

$conn->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS Gerer (
    StandardisteID INT,
    InterventionID INT,
    PRIMARY KEY (StandardisteID, InterventionID),
    FOREIGN KEY (StandardisteID) REFERENCES Standardiste(StandardisteID),
    FOREIGN KEY (InterventionID) REFERENCES Intervention(InterventionID)
)";

function getUserInfo($user_id)
{
    global $conn;
    $sql = "SELECT * FROM Utilisateur WHERE UserID = $user_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return false;
    }
}
$conn->query($sql);
$conn->close();
?>

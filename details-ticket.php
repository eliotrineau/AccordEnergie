<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('tables.php');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "AccordEnergie";

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Échec de la connexion à la base de données : " . $conn->connect_error);
}

$conn->select_db($dbname);

$interventionID = $_GET['id'];

$sql = "SELECT * FROM Intervention WHERE InterventionID = '$interventionID'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $date = $row['Date'];
    $typeDeProbleme = $row['TypeDeProbleme'];
    $commentaire = $row['Commentaire'];
    $dateIntervention = $row['DateIntervention'];
    $statut = $row['Statut'];
    $degreUrgence = $row['DegreUrgence'];
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/svg+xml" href="assets/logo.svg">
        <script src="https://cdn.tailwindcss.com"></script>
        <title>Accord Energie</title>
    </head>
    <body class="text-white">
        <div class="flex-col bg-[#580F3E] my-12 mx-24 p-12 rounded-xl"> 
            <div class="flex-col bg-[#677179] rounded-xl mb-4 py-1 px-2">
                <div class="flex">
                    <p class="mx-auto">Description de votre problème</p>
                </div>
                <hr class="mb-1">
                <p class="text-white"><?php echo $commentaire; ?></p>
            </div>
            <div class="flex-col bg-[#677179] rounded-xl mb-4 py-1 px-2">
                <div class="flex">
                    <p class="mx-auto">Date d'intervention</p>
                </div>
                <hr class="mb-1">
                <p class="text-white"><?php echo $dateIntervention; ?></p>
            </div>
            <div class="flex-col bg-[#677179] rounded-xl mb-4 py-1 px-2">
                <div class="flex">
                    <p class="mx-auto">Type de problème</p>
                </div>
                <hr class="mb-1">
                <p class="text-white"><?php echo $typeDeProbleme; ?></p>
            </div>
            <div class="flex-col bg-[#677179] rounded-xl mb-4 py-1 px-2">
                <div class="flex">
                    <p class="mx-auto">Date de création</p>
                </div>
                <hr class="mb-1">
                <p class="text-white"><?php echo $date; ?></p>
            </div>
            <div class="flex-col bg-[#677179] rounded-xl mb-4 py-1 px-2">
                <div class="flex">
                    <p class="mx-auto">Degré d'urgence</p>
                </div>
                <hr class="mb-1">
                <p class="text-white"><?php echo $degreUrgence; ?></p>
            </div>
            <div class="flex-col bg-[#677179] rounded-xl mb-4 py-1 px-2">
                <div class="flex">
                    <p class="mx-auto">Statut</p>
                </div>
                <hr class="mb-1">
                <p class="text-white"><?php echo $statut; ?></p>
            </div>
        </div>    
    </body>
    <?php
} else {
    echo "Aucun ticket trouvé.";
}
?>

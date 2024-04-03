<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('tables.php');
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
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "AccordEnergie";

    $conn = new mysqli($servername, $username, $password);

    if ($conn->connect_error) {
        die("Échec de la connexion à la base de données : " . $conn->connect_error);
    }

    $conn->select_db($dbname);
    
    ?>
    <?php
    if (isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
        $nom = $user['Nom'];
        $prenom = $user['Prenom'];
        $user_id = $user['UserID'];
        $user_info = getUserInfo($user_id);
        echo "<header class=\"flex justify-between bg-[#B32863]\">";
        echo "<div class=\"flex\">";
        echo "<img src=\"assets/logo.svg\" class=\"m-2\"/>";
        echo "<h1 class=\"text-center text-8xl mb-4 ml-4\">Accord Energie</h1>";
        echo "</div>";
        echo "<div class=\"flex\">";
        echo "<p class=\"text-4xl my-auto mr-4\">$nom $prenom</p>";
        echo "<nav class=\"flex items-center m-6 gap-2 text-2xl\">";
        echo "<a href=\"index.php\" class=\"bg-[#580F3E] rounded-xl px-4 py-2\">Deconnexion</a>";
        echo "</nav>";
        echo "</div>";
        echo "</header>";
    }
    ?>

    <section class="bg-[#B32863] m-8 rounded-xl">
        <h2 class="font-bold text-4xl my-2 mx-4">
            Demander une intervention
        </h2>
        <div class="flex bg-[#580F3E] justify-around mx-6 my-4 rounded-xl">
            <form action="interfacesTicketTraitement.php" method="POST" class="flex-col py-4">
                <div class="flex justify-center mb-4">
                    <p class="text-2xl mr-2 font-bold my-auto">
                        Création d'un ticket
                    </p>
                    <img src="assets/add.svg" />
                </div>
                <div class="flex bg-[#677179] mb-4 py-1 px-2 rounded-xl" id="categorieContainer">
                    <img class="mb-2" src="assets/loupe.svg" />
                    <select name="typeDeProbleme" class="text-white mx-auto mt-1 text-center bg-[#677179] rounded-xl mb-2" required>  
                        <option value="default" selected=true>Choisir une catégorie à votre problème</option>
                        <option value="Panne">Panne</option> 
                        <option value="Facture">Facture</option>   
                        <option value="Autres">Autres</option>  
                    </select>
                </div>
                <div class="flex bg-[#677179] mb-4 py-1 px-2 rounded-xl">
                    <img class="mb-2 mr-2" src="assets/timetable.svg" />
                    <p>Choisir une date d'intervention</p>
                    <input name="dateIntervention" class="text-white text-center bg-[#677179] ml-4 rounded-xl mb-2" type="date" value="<?php echo date("Y-m-d");?>" required>
                </div>
                <div>
                    <div class="flex-col bg-[#677179] mb-4 py-1 px-2 rounded-xl">
                        <div class="flex">
                            <img src="assets/notebook.svg" />
                            <p class="mx-auto">Description de votre problème</p>
                        </div>    
                        <hr class="mb-1">
                        <input type="text" name="commentaire" class="w-[400px] rounded-xl h-6 text-[#677179] px-2 py-1" required>
                    </div> 
                </div>
                <input type="hidden" name="clientID" value="<?php echo $user_info['UserID']; ?>">                
                <div class="flex justify-center mt-4">
                    <button type="submit" class="bg-[#B32863] text-2xl py-2 px-4 rounded-xl">
                        Soumettre
                    </button>
                </div>
            </form>

            <div class="flex-col py-4">
                <div class="flex mb-4">
                    <p class="text-2xl mr-2 font-bold my-auto">
                        Vos anciens tickets
                    </p>
                    <img src="assets/stopwatch.svg" />
                </div>
                <div class="overflow-y-scroll" style="max-height: 300px;">
                    <?php
                    $userID = $user_info['UserID'];

                    $sql = "SELECT * FROM Intervention WHERE ClientID IN (SELECT ClientID FROM Client WHERE UserID = '$userID')";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $interventionID = $row['InterventionID'];
                            $date = $row['Date'];
                            $typeDeProbleme = $row['TypeDeProbleme'];
                            $commentaire = $row['Commentaire'];
                            $dateIntervention = $row['DateIntervention'];
                            $statut = $row['Statut'];
                            $degreUrgence = $row['DegreUrgence'];
                            ?>
                            <div class="flex justify-center bg-[#580F3E] rounded-xl mt-4 p-4">
                                <div class="flex bg-[#677179] rounded-xl p-4">
                                    <p>
                                        <?php echo $date; ?>
                                    </p>
                                    <a target="_blank" href="details-ticket.php?id=<?php echo $interventionID; ?>"class="ml-[18px]">
                                        <img src="assets/dots.svg" />
                                    </a>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo "Aucun ticket trouvé.";
                    }
                    $conn->close();
                    ?>
                </div>
            </div>

            <div class="flex-col py-4">
                <div class="flex mb-4">
                    <p class="text-2xl mr-2 font-bold my-auto">
                        Contact d'urgence
                    </p>
                    <img src="assets/urgence.svg" />
                </div>
                <div class="flex-col py-24 bg-[#677179] rounded-xl h-[340px]">
                    <div class="flex justify-center mb-8">
                        <img src="assets/call.svg" class="mr-2" />
                        <a class="self-center">
                            +33 4 52 38 90 42
                        </a>
                    </div>
                    <div class="flex justify-center">
                        <img src="assets/mail.svg" class="mr-2" />
                        <a target="_blank" href="mailto:ae-urgence@yopmail.com?subject=[Insérer votre objet ici.]&amp;body=[Insérer votre demande ici.]" class="self-center">
                            ae-urgence@gmail.com
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex justify-center text-white">
            <div class="flex-col">
                <h2 class="font-bold text-center text-4xl my-2 mx-4">
                    Votre profil
                </h2>
                <div class="flex-col py-2 px-4 mb-4 rounded-xl bg-[#580F3E]">
                    <div class="flex-col w-[450px]">
                        <div class="flex justify-between mx-4 font-bold mb-4">
                            <p>
                                Nom :
                            </p>
                            <input value="<?php echo htmlspecialchars($user_info['Nom']); ?>" class="bg-[#677179] py-1 px-2 rounded-xl">
                        </div>
                        <div class="flex justify-between mx-4 font-bold mb-4">
                            <p>
                                Prénom :
                            </p>
                            <input value="<?php echo htmlspecialchars($user_info['Prenom']); ?>" class="bg-[#677179] py-1 px-2 rounded-xl">
                        </div>
                        <div class="flex justify-between mx-4 font-bold mb-4">
                            <p>
                                Mail :
                            </p>
                            <input value="<?php echo htmlspecialchars($user_info['Email']); ?>" class="bg-[#677179] py-1 px-2 rounded-xl">
                        </div>
                        <div class="flex justify-between mx-4 font-bold mb-4">
                            <p>
                                Téléphone :
                            </p>
                            <input value="<?php echo htmlspecialchars($user_info['Telephone']); ?>" class="bg-[#677179] py-1 px-2 rounded-xl">
                        </div>
                        <div class="flex justify-between mx-4 font-bold mb-4">
                            <p>
                                Adresse :
                            </p>
                            <input value="<?php echo htmlspecialchars($user_info['Adresse']); ?>" class="bg-[#677179] py-1 px-2 rounded-xl">
                        </div>
                        <div class="flex justify-between mx-4 font-bold mb-4">
                            <p>
                                Numéro de client :
                            </p>
                            <p class="bg-[#677179] py-1 px-2 rounded-xl">
                                <?php echo htmlspecialchars($user_info['UserID']); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>

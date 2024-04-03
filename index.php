<?php
include('db.php');
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
    
    /*
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
    if ($conn->query($sql) === TRUE) {
        echo "Base de données créée avec succès\n";
    } else {
        echo "Erreur lors de la création de la base de données : " . $conn->error;
    }
    */

    $conn->select_db($dbname);
    $conn->close();
    ?>
    <header class="flex justify-between bg-[#B32863]">
        <div class="flex">
            <img src="assets/logo.svg" class="m-2"/>
            <h1 class="text-center text-8xl mb-4 ml-4">
                Accord Energie
            </h1>
        </div>
        <nav class="flex items-center m-6 gap-2 text-2xl">
            <a href="connexion.php" class="bg-[#580F3E] rounded-xl px-4 py-2 ">
                Connexion
            </a>
            <a href="inscription.php" class="bg-[#580F3E] rounded-xl px-4 py-2 ">
                Inscription
            </a>
        </nav>
    </header>

    <section class="flex p-8 gap-4">

        <div class="flex-col w-[800px] mt-2">
            <div class="bg-[#B32863] mb-4 h-[270px] text-xs py-4 px-4 rounded-xl flex-col">

                <h2 class="text-center text-2xl font-bold mb-4">
                    Pour votre budget et la planète, choisissez-nous !
                </h2>

                <div class="flex justify-center gap-8">

                    <div class="flex-col bg-[#580F3E] rounded-xl p-2 w-[350px]">
                        <div class="flex justify-center">
                            <img class="scale-[0.8]" src="assets/renouvelable1.svg" />
                            <img class="scale-[0.8]" src="assets/renouvelable2.svg" />
                        </div>
                        <p class="text-center">
                            Pour une énergie verte, une partie de nos bénéfices est dédiée à la transition écologique
                        </p>
                    </div>
    
                    <div class="flex-col bg-[#580F3E] rounded-xl p-2 w-[350px]">
                        <div class="flex justify-center">
                            <img class="scale-[0.8]" src="assets/renouvelable3.svg" />
                        </div>
                        <p class="text-center">
                            Pour réduire notre impact carbone et viser la neutralité en 2030, notre flotte de véhicules est 100% électrique pour des interventions 100% vertes
                        </p>
                    </div>

                </div>
            </div>

            <div class="bg-[#B32863] h-[270px] text-xs py-4 px-4 rounded-xl flex-col">
                <h2 class="text-center text-2xl font-bold mb-4">
                    Le meilleur suivi client du secteur !
                </h2> 
                <div class="flex justify-center gap-8">

                    <div class="flex-col bg-[#580F3E] rounded-xl p-2 w-[350px]">
                        <div class="flex justify-center">
                            <img class="scale-[0.8]" src="assets/suivi.svg" />
                        </div>
                        <p class="text-center">
                            Des interventions datées avec un suivi précis !
                        </p>
                        <div class="flex justify-center mt-6">
                            <img class="scale-[0.8]" src="assets/review.svg" />
                        </div>
                        <p class="text-center">
                            Des techniciens qualifiés !
                        </p>
                    </div>

                    <div class="flex-col bg-[#580F3E] rounded-xl p-2 w-[350px]">
                        <div class="flex justify-center">
                            <img class="scale-[0.8]" src="assets/ecoute.svg" />
                        </div>
                        <p class="text-center">
                            Des standardistes à votre écoute
                        </p>
                        <div class="flex justify-center">
                            <img class="scale-[0.8]" src="assets/feedback.svg" />
                        </div>
                        <p class="text-center">
                            Vous pouvez communiquer avant, pendant et après sur l’intervention !
                        </p>
                    </div>

                </div>
            </div>
        </div>

        <div class="flex-col rounded-xl py-2 px-4 bg-[#B32863] w-[600px] h-[580px]">
            <h2 class="text-center text-2xl font-bold mb-4">
                Ils nous ont fait confiance !
            </h2>
            <div class="bg-[#580F3E] rounded-xl p-4 -mt-2">
                <div class="flex gap-8 mb-4">
                    <img src="assets/imageTemp.svg" />
                    <p>
                        Accord Energie est mon fournisseur d'électricité depuis 5 ans maintenant, je n'ai jamais eu de problème d'énergie depuis !
                    </p>
                </div>
                <div class="flex gap-8 mb-4">
                    <img class="rounded-full" src="assets/imageTemp2.svg" />
                    <p>
                        Je me suis intéressé aux différents fournisseurs d'énergie en France en 2019, j'ai choisi Accord Energie en regardant les avis sur internet, je peux affirmer qu'ils reflètent la qualité du service.
                    </p>
                </div>
                <div class="flex gap-8 mb-4">
                    <img class="rounded-full" src="assets/imageTemp3.svg" />
                    <p>
                        J'ai eu une fois un souci avec mon compteur électrique et leur service client a été d'une grande qualité, clairement un plus !
                    </p>
                </div>
                <div class="flex gap-8 mb-4">
                    <img class="rounded-full" src="assets/imageTemp4.svg" />
                    <p>
                        J'ai choisi ce fournisseur car c'est tout simplement le moins cher du marché et la qualité est identique sinon meilleure par rapport aux concurrents.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <footer class="flex justify-around bg-[#B32863] py-4">
        <div class="flex gap-2 bg-[#580F3E] py-2 px-4 rounded-xl">
            <a target="_blank" href="https://www.instagram.com/edfofficiel/">
                <img src="assets/insta.svg" />
            </a>
            <a target="_blank" href="https://twitter.com/EDFofficiel">
                <img src="assets/twitter.svg" />
            </a>
            <p>Suivez-nous</p>
            <a target="_blank" href="https://www.linkedin.com/company/edf/">
                <img src="assets/linkedin.svg" />
            </a>
            <a target="_blank" href="https://www.facebook.com/edf">
                <img src="assets/facebook.svg" />
            </a>
        </div>
        <a target="_blank" href="mailto:ae-service-client@yopmail.com?subject=[Insérer votre objet ici.]&amp;body=[Insérer votre demande ici.]" class="bg-[#580F3E] py-2 px-4 rounded-xl">
            Contact
        </a>
        <a target="_blank" href="https://www.edf.fr/mentions-legales" class="bg-[#580F3E] py-2 px-4 rounded-xl">
            Mentions légales
        </a>
        <a target="_blank" href="https://www.edf.fr/edf-recrute" class="bg-[#580F3E] py-2 px-4 rounded-xl">
            Nous rejoindre
        </a>
        <a target="_blank" href="https://www.edf.fr/resultats" class="bg-[#580F3E] py-2 px-4 rounded-xl">
            Chiffres clefs
        </a>
    </footer>
</body>
</html>

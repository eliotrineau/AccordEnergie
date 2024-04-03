<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $motDePasse = $_POST['motDePasse'];

    $stmt = $conn->prepare("SELECT * FROM Utilisateur WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($motDePasse, $row['MotDePasse'])) {
            session_start();
            $_SESSION['user'] = $row;
            switch ($row['TypeCompte']) {
                case 'Admin':
                    header("Location: admin.php");
                    break;
                case 'Standardiste':
                    header("Location: standardiste.php");
                    break;
                case 'Intervenant':
                    header("Location: intervenant.php");
                    break;
                default:
                    header("Location: interface.php");
            }
            exit();
        } else {
            echo "<script>alert('Mot de passe incorrect');</script>";
        }
    } else {
        echo "<script>alert('Utilisateur non trouvé');</script>";
    }
    $stmt->close();
    $conn->close();
}
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
    <header class="flex justify-start bg-[#B32863]">
        <div class="flex">
            <img src="assets/logo.svg" class="m-2"/>
            <h1 class="text-center text-8xl mb-4 ml-4">
                Accord Energie
            </h1>
        </div>
    </header>

    <div class="bg-[#580F3E] mx-[600px] flex justify-center my-[100px] p-4 rounded-xl">
        <div class="flex-col">
            <form action="connexion.php" method="post">
                <p class="font-bold text-2xl">
                    email :
                </p>
                <input type="text" name="email" class="rounded-xl font-bold text-black text-center mb-2 bg-zinc-300 h-[30px]" required>

                <p class="font-bold text-2xl mt-4">
                    mot de passe :
                </p>
                <input type="password" name="motDePasse" class="rounded-xl font-bold text-black text-center mb-2 bg-zinc-300 h-[30px]" required>

                <div class="flex justify-center mt-4">
                    <button type="submit" class="bg-[#B32863] py-2 px-4 rounded-xl text-2xl">
                        Se connecter
                    </button>
                </div>
            </form>

            <div class="flex justify-center mt-4">
                <a href="inscription.php" class="text-zinc-300 text-2xl">
                    S'inscrire
                </a>
            </div>
        </div>
    </div>
</body>
</html>

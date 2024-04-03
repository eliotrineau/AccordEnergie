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

    <div class="bg-[#580F3E] mx-[550px] mt-6 flex justify-center my-[100px] p-4 rounded-xl">
        <div class="flex-col">
            <form action="inscriptionTraitement.php" method="post">

                <p class="font-bold text-center text-2xl">
                    Nom :
                </p>
                <input type="text" name="nom" class="rounded-xl font-bold text-black text-center mb-2 bg-zinc-300 h-[30px] w-[300px]" required>

                <p class="font-bold text-center text-2xl">
                    Prénom :
                </p>
                <input type="text" name="prenom" class="rounded-xl font-bold text-black text-center mb-2 bg-zinc-300 h-[30px] w-[300px]" required>

                <p class="font-bold text-center text-2xl">
                    Téléphone :
                </p>
                <input type="text" name="telephone" class="rounded-xl font-bold text-black text-center mb-2 bg-zinc-300 h-[30px] w-[300px]" required>

                <p class="font-bold text-center text-2xl">
                    Adresse :
                </p>
                <input type="text" name="adresse" class="rounded-xl font-bold text-black text-center mb-2 bg-zinc-300 h-[30px] w-[300px]" required>

                <p class="font-bold text-center text-2xl">
                    email :
                </p>
                <input type="text" name="email" class="rounded-xl font-bold text-black text-center mb-2 bg-zinc-300 h-[30px] w-[300px]" required>

                <p class="font-bold text-center text-2xl">
                    confirmer email :
                </p>
                <input type="text" name="emailConfirmation" class="rounded-xl font-bold text-black text-center mb-2 bg-zinc-300 h-[30px] w-[300px]" required>

                <p class="font-bold text-center text-2xl">
                    mot de passe :
                </p>
                <input type="text" name="motDePasse" class="rounded-xl font-bold text-black text-center mb-2 bg-zinc-300 h-[30px] w-[300px]" required>

                <p class="font-bold text-center text-2xl">
                    confirmer mot de passe :
                </p>
                <input type="text" name="motDePasseConfirmation" class="rounded-xl font-bold text-black text-center mb-2 bg-zinc-300 h-[30px] w-[300px]" required>

                <div class="flex justify-center mt-4">
                    <button type="submit" class="bg-[#B32863] text-2xl py-2 px-4 rounded-xl">
                        S'inscrire
                    </button>
                </div>
            </form>

            <div class="flex justify-center mt-4">
                <a href="connexion.php" class="text-zinc-300 text-2xl">
                    Se connecter
                </a>
            </div>
        </div>
    </div>
</body>
</html>

<?php
require_once '../config/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prenom = sanitize_input($_POST['prenom'], $conn);
    $nom = sanitize_input($_POST['nom'], $conn);
    $email = sanitize_input($_POST['email'], $conn);
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    if ($password !== $confirm) {
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        // Vérifie si l'email existe déjà
        $check = $conn->prepare("SELECT id FROM admin_quiz WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $error = "Cet email est déjà enregistré.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO admin_quiz (prenom, nom, email, password) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $prenom, $nom, $email, $hash);
            $stmt->execute();
            header("Location: login?success=1");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Favicons -->
    <link href="https://i.postimg.cc/ZqS0t5js/sternaofficiel-2.png" rel="icon">
    <link href="https://i.postimg.cc/ZqS0t5js/sternaofficiel-2.png" rel="apple-touch-icon">
</head>

<body class="bg-stone-950 text-white flex items-center justify-center min-h-screen">
    <div class="gb-stone-800 p-4 rounded-2xl shadow-xl w-full max-w-lg">
        <h2 class="text-2xl font-bold text-center mb-6">Créer compte administrateur</h2>

        <?php if (!empty($error)): ?>
            <div class="bg-red-600 text-white p-3 rounded mb-4 text-center"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" class="space-y-6">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Prénom</label>
                    <input type="text" name="prenom" required class="w-full bg-stone-700 border border-gray-600 rounded-xl py-3 px-4 text-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Nom</label>
                    <input type="text" name="nom" required class="w-full bg-stone-700 border border-gray-600 rounded-xl py-3 px-4 text-white">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                <input type="email" name="email" required class="w-full bg-stone-700 border border-gray-600 rounded-xl py-3 px-4 text-white">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Mot de passe</label>
                <input type="password" name="password" required class="w-full bg-stone-700 border border-gray-600 rounded-xl py-3 px-4 text-white">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Confirmer le mot de passe</label>
                <input type="password" name="confirm" required class="w-full bg-stone-700 border border-gray-600 rounded-xl py-3 px-4 text-white">
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white py-3 rounded-xl transition-all duration-300">
                S'inscrire
            </button>

            <div class="text-center mt-4">
                <span class="text-gray-400">Déjà un compte ? </span>
                <a href="login" class="text-purple-400 hover:text-purple-300 font-medium">Se connecter</a>
            </div>
        </form>
    </div>
</body>

</html>
<?php
require_once '../config/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize_input($_POST['email'], $conn);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM admin_quiz WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['admin_quiz_id'] = $user['id'];
        header("Location: dashboard");
        exit;
    } else {
        $error = "Email ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Connexion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Favicons -->
    <link href="https://i.postimg.cc/ZqS0t5js/sternaofficiel-2.png" rel="icon">
    <link href="https://i.postimg.cc/ZqS0t5js/sternaofficiel-2.png" rel="apple-touch-icon">
</head>

<body class="bg-stone-950 text-white font-sans">

    <!-- Page Login -->
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full mx-4 p-2 bg-stone-900 rounded-2xl">
            <div class="text-center mb-8">

                <h1 class="text-3xl font-bold text-white">Admin - Connexion</h1>
                <p class="text-gray-400 mt-2">Accédez à votre tableau de bord</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="bg-red-600 text-white p-3 rounded mb-4 text-center"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                    <input type="email" class="w-full bg-stone-700 border border-gray-600 rounded-xl py-3 px-4 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-500" name="email" required placeholder="votre@email.com">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Mot de passe</label>
                    <input type="password" class="w-full bg-stone-700 border border-gray-600 rounded-xl py-3 px-4 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-500" name="password" required placeholder="Votre mot de passe">
                </div>

                <div class="flex items-center justify-between">
                    <a href="#" class="text-sm text-purple-400 hover:text-purple-300">Mot de passe oublié ?</a>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white py-3 rounded-xl transition-all duration-300">
                    Se connecter
                </button>

                <div class="text-center mt-4">
                    <span class="text-gray-400">Pas de compte ? </span>
                    <button type="button" onclick="window.location.href = 'register';" class="text-purple-400 hover:text-purple-300 font-medium">S'inscrire</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>
<?php
session_start();
require_once '../includes/db.php';

// 🟡 Création automatique d'un admin si aucun n'existe
try {
    $check = $pdo->query("SELECT COUNT(*) FROM users WHERE is_admin = 1");
    $adminCount = $check->fetchColumn();

    if ($adminCount == 0) {
        $defaultEmail = 'roys.esdras@outlook.com';
        $defaultPassword = 'admin123'; // À changer après première connexion
        $hashedPassword = password_hash($defaultPassword, PASSWORD_DEFAULT);

        $insert = $pdo->prepare("INSERT INTO users (name, email, password, is_admin) VALUES (?, ?, ?, 1)");
        $insert->execute(['Administrateur', $defaultEmail, $hashedPassword]);

        file_put_contents(__DIR__ . '/admin_creation_log.txt', "Admin auto-créé le " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
    }
} catch (Exception $e) {
    error_log("Erreur création auto admin : " . $e->getMessage());
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND is_admin = 1");
    $stmt->execute([$email]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['name'];
        $_SESSION['role'] = 'admin';

        // ✅ Redirection après connexion réussie
        header('Location: create_project.php');
        exit;
    } else {
        $error = "Identifiants invalides.";
    }
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Cahier d'Or</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Favicons -->
    <link href="https://i.postimg.cc/ZqS0t5js/sternaofficiel-2.png" rel="icon">
    <link href="https://i.postimg.cc/ZqS0t5js/sternaofficiel-2.png" rel="apple-touch-icon">
</head>

<body class="bg-gray-900 min-h-screen flex items-center justify-center text-white flex flex-col">

    <form method="POST" class="bg-gray-800 p-8 rounded-xl shadow-lg w-full max-w-sm border border-gray-700">
        <h2 class="text-2xl font-bold mb-6 text-center text-yellow-400">Admin - Cahier d'Or</h2>

        <?php if (!empty($error)): ?>
            <p class="text-red-400 mb-4"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <div class="mb-4">
            <label class="block text-sm text-gray-300">Email</label>
            <input type="email" name="email" required class="w-full bg-gray-700 border border-gray-600 p-2 rounded mt-1 text-white placeholder-gray-400" placeholder="admin@exemple.com">
        </div>

        <div class="mb-6">
            <label class="block text-sm text-gray-300">Mot de passe</label>
            <input type="password" name="password" required class="w-full bg-gray-700 border border-gray-600 p-2 rounded mt-1 text-white placeholder-gray-400" placeholder="••••••••">      
        </div>

        <!-- mp: admin123 -->
        <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-400 text-gray-900 font-semibold py-2 px-4 rounded-lg transition duration-200">
            Se connecter
        </button>
    </form>

    <?php include_once '../includes/footer.php'; ?>
</body>

</html>
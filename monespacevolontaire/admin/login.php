<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Connexion Formateur - Sterna Africa</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-white min-h-screen flex items-center justify-center p-4">
  <div class="w-full max-w-md bg-white p-6 md:p-8 rounded-xl shadow-md">
    <?php if (isset($_GET['message'])): ?>
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            <?= htmlspecialchars($_GET['message']) ?>
        </div>
    <?php endif; ?>
    
    <h2 class="text-2xl font-bold text-center text-blue-700 mb-6">Connexion Formateur</h2>
    <form action="login_process.php" method="POST" class="space-y-4">
      <div>
        <input type="email" name="email" placeholder="Adresse email" required class="w-full border border-gray-300 rounded px-3 py-2" />
      </div>
      <div>
        <input type="password" name="motdepasse" placeholder="Mot de passe" required class="w-full border border-gray-300 rounded px-3 py-2" />
      </div>
      <div class="flex justify-end text-sm">
        <a href="motdepasse-oublie.php" class="text-blue-500 hover:underline">Mot de passe oublié ?</a>
      </div>
      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">Se connecter</button>
    </form>
    <p class="text-center text-sm mt-4">Pas encore inscrit ? <a href="register.php" class="text-blue-500 hover:underline">Créer un compte</a></p>
  </div>
</body>
</html>

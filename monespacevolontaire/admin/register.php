<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Inscription Formateur - Sterna Africa</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-white min-h-screen flex items-center justify-center p-4">
  <div class="w-full max-w-md bg-white p-6 md:p-8 rounded-xl shadow-md">
    <h2 class="text-2xl font-bold text-center text-blue-700 mb-6">Inscription Formateur</h2>
    <form action="register_process.php" method="POST" enctype="multipart/form-data" class="space-y-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Photo de profil</label>
        <input type="file" name="avatar" accept="image/*" class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
      </div>
      <div>
        <input type="text" name="nom" placeholder="Nom" required class="w-full border border-gray-300 rounded px-3 py-2" />
      </div>
      <div>
        <input type="text" name="prenom" placeholder="Prénoms" required class="w-full border border-gray-300 rounded px-3 py-2" />
      </div>
      <div>
        <input type="email" name="email" placeholder="Adresse email" required class="w-full border border-gray-300 rounded px-3 py-2" />
      </div>
      <div>
        <input type="password" name="motdepasse" placeholder="Mot de passe" required class="w-full border border-gray-300 rounded px-3 py-2" />
      </div>
      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">S'inscrire</button>
    </form>
    <p class="text-center text-sm mt-4">Déjà un compte ? <a href="login.php" class="text-blue-500 hover:underline">Connexion</a></p>
  </div>
</body>
</html>

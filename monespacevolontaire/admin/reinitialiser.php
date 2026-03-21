<?php
require_once '../inclusion/db.php';

$token = $_GET['token'] ?? null;

if (!$token) {
    die("Lien invalide.");
}

// Vérifie le token
$stmt = $pdo->prepare("SELECT * FROM reset_tokens WHERE token = ? AND used = 0 AND expires_at > NOW()");
$stmt->execute([$token]);
$reset = $stmt->fetch();

if (!$reset) {
    die("Lien expiré ou invalide.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Réinitialisation</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen px-4">
  <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
    <h2 class="text-2xl font-bold mb-4 text-center">Nouveau mot de passe</h2>
    <form action="traitement_reinitialisation.php" method="POST">
      <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

      <div class="mb-4">
        <label class="block mb-1 text-sm">Nouveau mot de passe</label>
        <input type="password" name="password" required class="w-full border rounded px-3 py-2">
      </div>

      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Réinitialiser</button>
    </form>
  </div>
</body>
</html>

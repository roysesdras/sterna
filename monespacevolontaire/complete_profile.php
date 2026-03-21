<?php
session_start();
require_once './inclusion/db.php';

if (!isset($_SESSION['google_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $date_naissance = $_POST['date_naissance'];
    $annee_integration = $_POST['annee_integration'];
    $genre = $_POST['genre'];
    $telephone = $_POST['telephone'];
    $ville = $_POST['ville'];
    $profession = $_POST['profession'];
    $competences = $_POST['competences'];
    $disponibilite = $_POST['disponibilite'];
    $motivation = $_POST['motivation'];

    $avatar = null;
    $current_avatar = null;

    // On récupère l'ancien avatar si aucun nouveau n'est uploadé
    $stmt = $pdo->prepare("SELECT avatar FROM users WHERE google_id=?");
    $stmt->execute([$_SESSION['google_id']]);
    $current_avatar = $stmt->fetchColumn();

    $avatar = null;

    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
        $ext = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($ext, $allowedExtensions)) {
            die("Format de fichier non autorisé !");
        }

        $newFilename = uniqid() . '.' . $ext;
        $uploadDir = __DIR__ . '/uploads/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $avatarPath = $uploadDir . $newFilename;

        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $avatarPath)) {
            $avatar = 'uploads/' . $newFilename;
        } else {
            die("Erreur lors de l'upload !");
        }
    }

    // Si aucun nouvel avatar, garde l’ancien
    if (!$avatar && !empty($current_avatar)) {
        $avatar = $current_avatar;
    }


    $telephone = preg_replace('/[^0-9+]/', '', $telephone);
    if (preg_match('/^\+?[0-9]{9,15}$/', $telephone) === 0) {
        die("Numéro de téléphone invalide.");
    }

    // ✅ Mise à jour avec profile_completed = 1
    $stmt = $pdo->prepare("UPDATE users SET nom=?, prenom=?, date_naissance=?, annee_integration=?, genre=?, telephone=?, ville=?, profession=?, competences=?, disponibilite=?, motivation=?, avatar=?, profile_completed=1 WHERE google_id=?");
    $stmt->execute([$nom, $prenom, $date_naissance, $annee_integration, $genre, $telephone, $ville, $profession, $competences, $disponibilite, $motivation, $avatar, $_SESSION['google_id']]);

    header("Location: /");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finaliser l’inscription</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Favicons -->
    <link href="https://i.postimg.cc/ZqS0t5js/sternaofficiel-2.png" rel="icon">
    <link href="https://i.postimg.cc/ZqS0t5js/sternaofficiel-2.png" rel="apple-touch-icon">
</head>

<body class="min-h-screen bg-gray-900 text-white flex flex-col items-center justify-center px-4">

    <div class="w-full max-w-2xl bg-gray-800 p-4 rounded-2xl shadow-lg mb-6 mt-4">
        <h1 class="text-2xl font-bold mb-6 text-center">Finaliser votre inscription</h1>

        <form method="POST" enctype="multipart/form-data" class="space-y-5">
            <div>
                <label for="avatar" class="block mb-2 font-medium">Photo / Avatar</label>
                <input type="file" name="avatar" id="avatar" accept="image/*" required
                    class="block w-full text-sm text-gray-300 bg-gray-700 border border-gray-600 rounded-lg cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500">
                <div id="preview" class="mt-4 hidden">
                    <img src="" alt="Aperçu de l’avatar" class="w-50 h-50 rounded-lg object-cover">
                </div>
            </div>

            <div>
                <label for="nom" class="block mb-2 font-medium">Prénoms</label>
                <input type="text" name="nom" id="nom" required
                    class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600 text-white focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="prenom" class="block mb-2 font-medium">Nom</label>
                <input type="text" name="prenom" id="prenom" required
                    class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600 text-white focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="date_naissance" class="block mb-2 font-medium">Date de naissance</label>
                <input type="date" name="date_naissance" id="date_naissance" required
                    class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600 text-white focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="annee_integration" class="block mb-2 font-medium">Année d'adhésion</label>
                <select name="annee_integration" id="annee_integration" required
                    class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600 text-white focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Sélectionnez une année --</option>
                    <?php
                    $annee_courante = date("Y");
                    for ($annee = 2000; $annee <= $annee_courante; $annee++) {
                        echo "<option value=\"$annee\">$annee</option>";
                    }
                    ?>
                </select>
                <p class="text-sm text-gray-400 mt-1">En quelle année avez-vous adhéré à Sterna Africa ?</p>
            </div>

            <div>
                <label for="genre" class="block mb-2 font-medium">Genre</label>
                <select name="genre" id="genre" required
                    class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600 text-white focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Sélectionnez --</option>
                    <option value="Homme">Homme</option>
                    <option value="Femme">Femme</option>
                    <option value="Autre">Autre</option>
                </select>
            </div>

            <div>
                <label for="telephone" class="block mb-2 font-medium">Numéro WhatsApp</label>
                <input type="tel" name="telephone" id="telephone" maxlength="15" pattern="^\+\d{1,3}\s?\d{6,12}$" required
                    placeholder="+225 0700000000"
                    class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600 text-white focus:ring-2 focus:ring-blue-500"
                    oninput="formatPhoneNumber(this)">
                <p class="text-sm text-gray-400 mt-1">Format attendu : <code>+225 0700000000</code> (préfixe obligatoire, 15 caractères max)</p>
            </div>

            <script>
                function formatPhoneNumber(input) {
                    // Supprime tout caractère sauf + et chiffres
                    let cleaned = input.value.replace(/[^\d+]/g, '');

                    // Si plusieurs "+" sont présents, on en garde qu’un seul au début
                    cleaned = cleaned.replace(/\++/g, '+').replace(/(?!^)\+/, '');

                    // Ajoute un espace après le préfixe (ex: +229 97...)
                    const match = cleaned.match(/^(\+\d{1,3})(\d{0,12})$/);
                    if (match) {
                        input.value = `${match[1]} ${match[2]}`;
                    } else {
                        input.value = cleaned;
                    }

                    // Limite la longueur à 15 caractères max (avec espace inclus)
                    if (input.value.length > 15) {
                        input.value = input.value.substring(0, 15);
                    }
                }
            </script>

            <div>
                <label for="ville" class="block mb-2 font-medium">Ville</label>
                <input type="text" name="ville" id="ville" required
                    class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600 text-white focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="profession" class="block mb-2 font-medium">Profession</label>
                <input type="text" name="profession" id="profession" placeholder="En un mot ou deux, votre activité professionnelle" required
                    class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600 text-white focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="competences" class="block mb-2 font-medium">Compétences (séparées par des virgules)</label>
                <input type="text" name="competences" id="competences" placeholder="Communication, Animation, ..." required
                    class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600 text-white focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="disponibilite" class="block mb-2 font-medium">Disponibilité</label>
                <select name="disponibilite" id="disponibilite" required
                    class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600 text-white focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Choisir --</option>
                    <option value="Plein temps">Plein temps</option>
                    <option value="Temps partiel">Temps partiel</option>
                    <option value="Week-ends uniquement">Week-ends uniquement</option>
                    <option value="Occasionnel">Occasionnel</option>
                </select>
            </div>

            <div>
                <label for="motivation" class="block mb-2 font-medium">Qu’est-ce qui vous inspire à vous engager comme volontaire ?</label>
                <textarea name="motivation" id="motivation" rows="4" required
                    class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600 text-white focus:ring-2 focus:ring-blue-500"></textarea>
            </div>

            <button type="submit"
                class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 rounded-lg text-white font-semibold transition duration-200">
                Finaliser l'inscription
            </button>
        </form>
    </div>

    <footer class="text-center py-4 text-sm text-gray-500">
        © <?php echo date('Y'); ?> Sterna Africa. Tous droits réservés.
    </footer>

    <script>
        const avatarInput = document.getElementById('avatar');
        const preview = document.getElementById('preview');
        const previewImg = preview.querySelector('img');

        avatarInput.addEventListener('change', () => {
            const file = avatarInput.files[0];
            if (file) {
                previewImg.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
            }
        });
    </script>
</body>

</html>
<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// Connexion à la base de données
$servername = "db";
$username = "root";
$password = "SoftiP24";
$dbname = "africa_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// echo '<pre>';
// print_r($_POST);
// echo '</pre>';
// exit;

// Récupération et protection des données
$fullname = isset($_POST['fullname']) ? $conn->real_escape_string(trim($_POST['fullname'])) : '';
$email = isset($_POST['email']) ? $conn->real_escape_string(trim($_POST['email'])) : '';
$numero = isset($_POST['numero']) ? $conn->real_escape_string(trim($_POST['numero'])) : '';
$nationalite = isset($_POST['nationalite']) ? $conn->real_escape_string(trim($_POST['nationalite'])) : '';
$age = isset($_POST['age']) ? implode(", ", $_POST['age']) : '';
$profession = isset($_POST['profession']) ? $conn->real_escape_string(trim($_POST['profession'])) : '';
$organisation = isset($_POST['organisation']) ? $conn->real_escape_string(trim($_POST['organisation'])) : '';
$nom_organisation = isset($_POST['nom_organisation']) ? $conn->real_escape_string(trim($_POST['nom_organisation'])) : '';
$membre = isset($_POST['membre']) ? $conn->real_escape_string(trim($_POST['membre'])) : '';
$nom_membre_organisation = isset($_POST['nom_membre_organisation']) ? $conn->real_escape_string(trim($_POST['nom_membre_organisation'])) : '';
$sources = isset($_POST['sources']) ? implode(", ", $_POST['sources']) : '';
$motivation = isset($_POST['motivation']) ? $conn->real_escape_string(trim($_POST['motivation'])) : '';
$volonteer = isset($_POST['volonteer']) ? $conn->real_escape_string(trim($_POST['volonteer'])) : '';
$engagement_gratuit = isset($_POST['engagement_gratuit']) ? $conn->real_escape_string(trim($_POST['engagement_gratuit'])) : '';
$contribution = isset($_POST['contribution']) ? $conn->real_escape_string(trim($_POST['contribution'])) : '';
$disponibilite = isset($_POST['disponibilite']) ? $conn->real_escape_string(trim($_POST['disponibilite'])) : '';
$passeport = isset($_POST['passeport']) ? $conn->real_escape_string(trim($_POST['passeport'])) : '';
$qualites = isset($_POST['qualites']) ? $conn->real_escape_string(trim($_POST['qualites'])) : '';
$defauts = isset($_POST['defauts']) ? $conn->real_escape_string(trim($_POST['defauts'])) : '';
$apport = isset($_POST['apport']) ? $conn->real_escape_string(trim($_POST['apport'])) : '';
$dernierMot = isset($_POST['dernierMot']) ? $conn->real_escape_string(trim($_POST['dernierMot'])) : '';

// Gestion de l'image
$imagePath = '';
$allowedExtensions = ['jpg', 'jpeg', 'png'];
$maxSize = 2 * 1024 * 1024; // 2 Mo

// 1. VERIFICATION : Est-ce que le fichier existe et n'est pas vide ?
if (!isset($_FILES['imageUpload']) || $_FILES['imageUpload']['error'] === UPLOAD_ERR_NO_FILE) {
    die("Erreur : La photo est obligatoire. Veuillez sélectionner une image.");
}

// 2. Vérification des erreurs système lors de l'envoi
if ($_FILES['imageUpload']['error'] !== UPLOAD_ERR_OK) {
    die("Erreur lors du transfert de l'image (Code d'erreur : " . $_FILES['imageUpload']['error'] . ").");
}

// 3. Traitement si tout est OK
$imageTmpName = $_FILES['imageUpload']['tmp_name'];
$imageName = basename($_FILES['imageUpload']['name']);

// Vérification de l'extension
$imageExtension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
if (!in_array($imageExtension, $allowedExtensions)) {
    die("Extension de fichier non autorisée. Utilisez JPG, JPEG ou PNG.");
}

// Vérification de la taille (On garde 2 Mo comme défini en variable)
if ($_FILES['imageUpload']['size'] > $maxSize) {
    die("Le fichier est trop volumineux. La taille maximale autorisée est de 2 Mo.");
}

// Création du dossier s'il n'existe pas
if (!is_dir('uploads')) {
    mkdir('uploads', 0777, true);
}

// Génération du chemin de sauvegarde unique
$imagePath = 'uploads/' . uniqid() . '-' . $imageName;

// Déplacement du fichier
if (!move_uploaded_file($imageTmpName, $imagePath)) {
    die("Erreur technique lors du déplacement de l'image.");
}


// Préparer et exécuter la requête
$sql = "INSERT INTO benevoles (fullname, email, numero, nationalite, age, profession, organisation, nom_organisation, membre, nom_membre_organisation, sources, motivation, volonteer, engagement_gratuit, contribution, disponibilite, passeport, qualites, defauts, apport, dernierMot, image_path) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "ssssssssssssssssssssss",
    $fullname,
    $email,
    $numero,
    $nationalite,
    $age,
    $profession,
    $organisation,
    $nom_organisation,
    $membre,
    $nom_membre_organisation,
    $sources,
    $motivation,
    $volonteer,
    $engagement_gratuit,
    $contribution,
    $disponibilite,
    $passeport,
    $qualites,
    $defauts,
    $apport,
    $dernierMot,
    $imagePath
);

// Exécuter la requête et vérifier
if ($stmt->execute()) {
    echo '
    <div style="text-align: center; padding: 20px; background-color: #f4f4f9; border-radius: 10px; font-family: Arial, sans-serif;">
        <h2 style="color: #28a745;">Soumission enregistrée avec succès !</h2>
        <p style="font-size: 18px; color: #333;">Votre candidature a été enregistrée avec succès. Après examen, un lien d\'intégration WhatsApp vous sera envoyé par e-mail si votre candidature est validée. <br><br>Veuillez vérifier votre boîte e-mail de temps à autre pour toute mise à jour concernant votre candidature.</p>
        <p style="font-size: 16px; color: #555;"><br>Merci de votre intérêt pour rejoindre Sterna Africa !</p>
        <a href="https://sternaafrica.org/" style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; font-size: 18px; margin-top: 20px;">Retour à l\'accueil</a>
    </div>';
} else {
    echo "Erreur lors de l'enregistrement : " . $conn->error;
}

// Fermer la déclaration et la connexion
$stmt->close();
$conn->close();

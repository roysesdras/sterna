<?php
// Connexion à la base de données
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';

// try {
//     $pdo = new PDO('mysql:host=localhost;dbname=u694220522_africa_db', 'u694220522_sterna_africa', '@sterna_Africa225');
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// } catch (PDOException $e) {
//     die("Erreur de connexion : " . $e->getMessage());
// }

// Vérifier si une modification est demandée
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['question_id'], $_POST['question_text'])) {
    $question_id = (int) $_POST['question_id'];
    $question_text = trim($_POST['question_text']);

    if ($question_id > 0 && !empty($question_text)) {
        $sql_update = "UPDATE questions SET question_text = :question_text WHERE id = :question_id";
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->execute(['question_id' => $question_id, 'question_text' => $question_text]);
        echo "<div class='alert alert-success'>Question modifiée avec succès !</div>";
    } else {
        echo "<div class='alert alert-danger'>Veuillez remplir tous les champs.</div>";
    }
}

// Récupérer les questions existantes
$sql_questions = "SELECT q.id, q.question_text, m.title AS mission_nom 
FROM questions q 
JOIN missions m ON q.mission_id = m.id 
ORDER BY m.title ASC, q.id ASC";
$stmt_questions = $pdo->query($sql_questions);
$questions = $stmt_questions->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <script src="../assets/js/color-modes.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une Question</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://sternaafrica.org/assets/img/logos/sternaofficiel-2.png" rel="icon">
    <link href="https://sternaafrica.org/assets/img/logos/sternaofficiel-2.png" rel="apple-touch-icon">
    <link rel="stylesheet" href="../assets/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <h2 class="text-center mb-4">Modifier une Question</h2>
                <!-- Formulaire de modification -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form method="post">
                            <div class="mb-3">
                                <label for="question_id" class="form-label">Sélectionner une question :</label>
                                <select name="question_id" id="question_id" class="form-select form-control" required>
                                    <option value="">-- Sélectionner une question --</option>
                                    <?php foreach ($questions as $question): ?>
                                        <option value="<?php echo $question['id']; ?>">
                                            <?php echo htmlspecialchars($question['mission_nom'] . " - " . $question['question_text']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="question_text" class="form-label">Nouvelle question :</label>
                                <textarea name="question_text" id="question_text" class="form-control" rows="3" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-warning">Modifier la question</button>
                        </form>
                    </div>
                </div>
                <div class="text-left mt-4">
                    <button onclick="history.back()" class="btn btn-secondary mt-3">Retour</button>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>


    <?php require_once('../config/footer_2.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
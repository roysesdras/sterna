<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';

// ON ACTIVE LA CONNEXION PDO ICI (INDISPENSABLE)
// On utilise les variables $host, $dbname, etc., qui viennent de db.php
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Suppression d'une question
if (isset($_GET['delete_id'])) {
    $delete_id = (int) $_GET['delete_id'];
    $sql_delete = "DELETE FROM questions WHERE id = :id";
    $stmt_delete = $pdo->prepare($sql_delete);
    $stmt_delete->execute(['id' => $delete_id]);

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Récupération des missions - Maintenant $pdo existe !
$sql_missions = "SELECT id, title FROM missions ORDER BY title ASC";
$stmt_missions = $pdo->query($sql_missions);
$missions = $stmt_missions->fetchAll(PDO::FETCH_ASSOC);

// Ajout d'une nouvelle question
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mission_id'], $_POST['question_text'])) {
    $mission_id = (int) $_POST['mission_id'];
    $question_text = trim($_POST['question_text']);

    if ($mission_id > 0 && !empty($question_text)) {
        $sql_insert = "INSERT INTO questions (mission_id, question_text) VALUES (:mission_id, :question_text)";
        $stmt_insert = $pdo->prepare($sql_insert);
        $stmt_insert->execute(['mission_id' => $mission_id, 'question_text' => $question_text]);

        // Redirection après ajout
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Récupération des questions existantes
$sql_questions = "SELECT q.id, q.question_text, m.title AS mission_nom 
FROM questions q 
JOIN missions m ON q.mission_id = m.id 
ORDER BY m.title ASC, q.id ASC";
$stmt_questions = $pdo->query($sql_questions);
$questions = $stmt_questions->fetchAll(PDO::FETCH_ASSOC);
$mission_counts = array_count_values(array_column($questions, 'mission_nom'));
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Questions</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://sternaafrica.org/assets/img/logos/sternaofficiel-2.png" rel="icon">
    <link href="https://sternaafrica.org/assets/img/logos/sternaofficiel-2.png" rel="apple-touch-icon">
    <link rel="stylesheet" href="../assets/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>

    <style>
        /* Ajustement des colonnes */
        .table th,
        .table td {
            vertical-align: middle;
        }

        /* Largeur spécifique pour chaque colonne */
        .col-id {
            width: 3%;
        }

        .col-mission {
            width: 40%;
            word-wrap: break-word;
            white-space: normal;
        }

        .col-question {
            width: 45%;
            word-wrap: break-word;
            white-space: normal;
        }

        .col-actions {
            width: 10%;
        }
    </style>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <h2 class="text-center mb-4">Ajouter Questions</h2>
                <!-- Formulaire d'ajout -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <form method="post">
                            <div class="mb-3">
                                <label for="mission_id" class="form-label">Mission :</label>
                                <select name="mission_id" id="mission_id" class="form-select" required>
                                    <option value="">Sélectionner une mission</option>
                                    <?php foreach ($missions as $mission): ?>
                                        <option value="<?= $mission['id'] ?>"><?= htmlspecialchars($mission['title']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="question_text" class="form-label">Question :</label>
                                <input type="text" name="question_text" id="question_text" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-success">Ajouter la question</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Tableau des questions -->
            <div class="card-header bg-secondary text-white">Liste des Questions et Missions</div>
            <div class="card-body">
                <?php if (!empty($questions)): ?>
                    <table class="table table-striped table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th class="col-id">ID</th>
                                <th class="col-mission">Mission</th>
                                <th class="col-question">Question</th>
                                <th class="col-actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $current_mission = null; ?>
                            <?php foreach ($questions as $question): ?>
                                <tr>
                                    <td><?php echo $question['id']; ?></td>
                                    <?php if ($question['mission_nom'] !== $current_mission): ?>
                                        <td rowspan="<?php echo $mission_counts[$question['mission_nom']]; ?>" class="col-mission">
                                            <strong><?php echo htmlspecialchars($question['mission_nom']); ?></strong>
                                        </td>
                                        <?php $current_mission = $question['mission_nom']; ?>
                                    <?php endif; ?>
                                    <td class="col-question"><?php echo htmlspecialchars($question['question_text']); ?></td>
                                    <td class="col-actions">
                                        <a href="edit_question_temoignage.php?id=<?php echo $question['id']; ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i></a>
                                        <a href="?delete_id=<?php echo $question['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer cette question ?');"><i class="bi bi-trash-fill"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="text-center text-muted">Aucune question disponible.</p>
                <?php endif; ?>
            </div>
            <div class="col-md-3"></div>
        </div>

        <div class="text-left mt-4 mb-4">
            <button onclick="history.back()" class="btn btn-outline-secondary">Retour</button>
        </div>
    </div>


    <?php require_once('../config/footer_2.php'); ?>
</body>

</html>
<?php
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pseudo'], $_POST['comment'], $_POST['entry_id'])) {
    
    $pseudo = trim($_POST['pseudo']);
    $comment = trim($_POST['comment']);
    $entry_id = (int)$_POST['entry_id'];

    if (empty($pseudo) || empty($comment) || $entry_id <= 0) {
        echo json_encode(['success' => false]);
        exit();
    }

    $pseudo = htmlspecialchars($pseudo, ENT_QUOTES, 'UTF-8');
    $comment = htmlspecialchars($comment, ENT_QUOTES, 'UTF-8');

    try {
        $stmt = $pdo->prepare("
            SELECT COUNT(*) 
            FROM comments 
            WHERE entry_id = ? AND pseudo = ? AND comment = ? 
            AND created_at > DATE_SUB(NOW(), INTERVAL 10 SECOND)
        ");
        $stmt->execute([$entry_id, $pseudo, $comment]);

        if ($stmt->fetchColumn() > 0) {
            echo json_encode(['success' => false]);
            exit();
        }

        $stmt = $pdo->prepare("INSERT INTO comments (entry_id, pseudo, comment, created_at) VALUES (?, ?, ?, NOW())");
        $result = $stmt->execute([$entry_id, $pseudo, $comment]);

        if ($result) {
            // LOGGING dans un fichier local
            file_put_contents(
                __DIR__ . '/logs/comment_log.txt',
                "[" . date('Y-m-d H:i:s') . "] New comment on entry #$entry_id by $pseudo: " . strip_tags($comment) . "\n",
                FILE_APPEND
            );

            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }

    } catch (Exception $e) {
        echo json_encode(['success' => false]);
    }

} else {
    echo json_encode(['success' => false]);
}

exit();

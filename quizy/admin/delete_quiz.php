<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/quizy/includes/init.php';


error_reporting(E_ALL);
ini_set('display_errors', 1);


echo "<pre>Sesja przed sprawdzeniem: ";
print_r($_SESSION);
echo "</pre>";


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = "Brak uprawnień administratora";
    header("Location: /quizy/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['quiz_id'])) {
    $_SESSION['error'] = "Nieprawidłowe żądanie";
    header("Location: /quizy/quizzes.php");
    exit();
}

$quiz_id = (int)$_POST['quiz_id'];

try {
    
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("DELETE FROM answer_options WHERE quiz_id = ?");
    $stmt->execute([$quiz_id]);
    $answers_deleted = $stmt->rowCount();

    $stmt = $pdo->prepare("DELETE FROM questions WHERE quiz_id = ?");
    $stmt->execute([$quiz_id]);
    $questions_deleted = $stmt->rowCount();

    $stmt = $pdo->prepare("DELETE FROM quizzes WHERE id = ?");
    $stmt->execute([$quiz_id]);
    $quiz_deleted = $stmt->rowCount();

    $pdo->commit();
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

    if ($quiz_deleted > 0) {
        $_SESSION['success'] = "Usunięto quiz (ID: $quiz_id) i powiązane elementy";
    } else {
        $_SESSION['error'] = "Quiz o ID $quiz_id nie został znaleziony";
    }

} catch (PDOException $e) {
    $pdo->rollBack();
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    $_SESSION['error'] = "Błąd bazy danych: " . $e->getMessage();
    error_log("Błąd usuwania quizu: " . $e->getMessage());
}

header("Location: /quizy/quizzes.php");
exit();
?>
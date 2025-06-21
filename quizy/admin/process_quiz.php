<?php
require_once __DIR__ . '/../includes/header.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);


if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

require_once('../config/db.php');
$db = getDbConnection();


$stmt = $db->prepare("SELECT role FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if (!$user || $user['role'] !== 'admin') {
    $_SESSION['role'] = $user['role'] ?? 'user';
    header("Location: ../profile.php?error=no_permission");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db->beginTransaction();

   
        $title = trim($_POST['title']);
        $description = trim($_POST['description'] ?? '');
        $category = trim($_POST['category']);
        $type = $_POST['type'];
        $created_by = $_SESSION['user_id'];

        if (empty($title) || empty($category) || empty($type)) {
            throw new Exception("Wypełnij wszystkie wymagane pola");
        }

       
        $quizQuery = "INSERT INTO quizzes 
                     (title, description, category, question_type, created_by) 
                     VALUES (?, ?, ?, ?, ?)";
        $stmt = $db->prepare($quizQuery);
        $stmt->execute([$title, $description, $category, $type, $created_by]);
        $quizId = $db->lastInsertId();

        foreach ($_POST['questions'] as $questionData) {
            $questionText = trim($questionData['text']);
            if (empty($questionText)) continue;

            $questionQuery = "INSERT INTO questions 
                            (quiz_id, question_text, correct_answer) 
                            VALUES (?, ?, '')";
            $stmt = $db->prepare($questionQuery);
            $stmt->execute([$quizId, $questionText]);
            $questionId = $db->lastInsertId();

  
            $hasCorrectAnswer = false;
            foreach ($questionData['answers'] as $answerData) {
                $answerText = trim($answerData['text']);
                $isCorrect = isset($answerData['correct']) ? 1 : 0;
                
                if (empty($answerText)) continue;

                if ($isCorrect) $hasCorrectAnswer = true;


                $answerQuery = "INSERT INTO answer_options 
                               (question_id, quiz_id, option_text, is_correct) 
                               VALUES (?, ?, ?, ?)";
                $stmt = $db->prepare($answerQuery);
                $stmt->execute([$questionId, $quizId, $answerText, $isCorrect]);
            }

            if (!$hasCorrectAnswer) {
                throw new Exception("Każde pytanie musi mieć co najmniej jedną poprawną odpowiedź");
            }
        }

        $db->commit();
        header("Location: ../quizzes.php?success=1");
        exit();

    } catch (Exception $e) {
        $db->rollBack();
        header("Location: create_quiz.php?error=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    header("Location: create_quiz.php");
    exit();
}
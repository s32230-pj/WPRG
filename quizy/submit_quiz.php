<?php
$pageTitle = 'Strona Główna';
require_once __DIR__ . '/includes/header.php';
?>


    <div class="container">
        <?php
    
        $host = "localhost";
        $dbname = "quizyowszystkim";
        $username = "root";
        $password = "";

        try {
            $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

       
            $quiz_id = isset($_POST['quiz_id']) ? intval($_POST['quiz_id']) : 0;

       
            $quiz_query = "SELECT title FROM quizzes WHERE id = ?";
            $quiz_stmt = $db->prepare($quiz_query);
            $quiz_stmt->execute([$quiz_id]);
            $quiz = $quiz_stmt->fetch(PDO::FETCH_ASSOC);

            if (!$quiz) {
                echo '<section class="section"><h2 class="section-title">Błąd</h2><p>Quiz nie istnieje.</p></section>';
            } else {
                echo '
                <section class="section">
                    <h2 class="quiz-title">Wynik quizu: ' . htmlspecialchars($quiz['title']) . '</h2>
                </section>';

         
                $questions_query = "SELECT id, question_text, correct_answer FROM questions WHERE quiz_id = ?";
                $questions_stmt = $db->prepare($questions_query);
                $questions_stmt->execute([$quiz_id]);
                $questions = $questions_stmt->fetchAll(PDO::FETCH_ASSOC);

                $total_questions = count($questions);
                $correct_answers = 0;

                if ($total_questions > 0) {
                    foreach ($questions as $question) {
                        $user_answer_key = 'question_' . $question['id'];
                        $user_answer_id = isset($_POST[$user_answer_key]) ? intval($_POST[$user_answer_key]) : null;

                      
                        $user_answer_text = "Nie udzielono odpowiedzi";
                        $is_correct = false;

                        if ($user_answer_id) {
                            $answer_query = "SELECT option_text, is_correct FROM answer_options WHERE id = ?";
                            $answer_stmt = $db->prepare($answer_query);
                            $answer_stmt->execute([$user_answer_id]);
                            $user_answer = $answer_stmt->fetch(PDO::FETCH_ASSOC);

                            if ($user_answer) {
                                $user_answer_text = $user_answer['option_text'];
                                $is_correct = $user_answer['is_correct'];
                                if ($is_correct) $correct_answers++;
                            }
                        }

               
                        echo '
                        <section class="section question-result ' . ($is_correct ? 'correct' : 'incorrect') . '">
                            <div class="question-text">' . htmlspecialchars($question['question_text']) . '</div>
                            <p>Twoja odpowiedź: <span class="user-answer">' . htmlspecialchars($user_answer_text) . '</span></p>
                            <p>Poprawna odpowiedź: <span class="correct-answer">' . htmlspecialchars($question['correct_answer']) . '</span></p>
                        </section>';
                    }

              
                    $score = round(($correct_answers / $total_questions) * 100);

           
                    if (isset($_SESSION['user_id'])) {
                   
                        $user_id = $_SESSION['user_id'];
                        $current_time = date('Y-m-d H:i:s');
                        
                  
                        $check_query = "SELECT id FROM user_stats WHERE user_id = ? AND quiz_id = ?";
                        $check_stmt = $db->prepare($check_query);
                        $check_stmt->execute([$user_id, $quiz_id]);
                        
                        if ($check_stmt->rowCount() > 0) {
                 
                            $update_query = "UPDATE user_stats SET score = ?, completed_at = ? WHERE user_id = ? AND quiz_id = ?";
                            $update_stmt = $db->prepare($update_query);
                            $update_stmt->execute([$score, $current_time, $user_id, $quiz_id]);
                        } else {
   
                            $insert_query = "INSERT INTO user_stats (user_id, quiz_id, score, completed_at) VALUES (?, ?, ?, ?)";
                            $insert_stmt = $db->prepare($insert_query);
                            $insert_stmt->execute([$user_id, $quiz_id, $score, $current_time]);
                        }
                    }


                    echo '
                    <section class="section result-summary">
                        <h3 class="section-title">Twój wynik</h3>
                        <div class="score">' . $score . '%</div>
                        <p>Poprawne odpowiedzi: ' . $correct_answers . ' / ' . $total_questions . '</p>
                        <a href="quiz.php?id=' . $quiz_id . '" class="btn">Spróbuj ponownie</a>
                        <a href="quizzes.php" class="btn">Inne quizy</a>
                    </section>';
                } else {
                    echo '<section class="section"><p>Brak pytań w tym quizie.</p></section>';
                }
            }
        } catch (PDOException $e) {
            echo '<section class="section"><p>Błąd połączenia z bazą danych: ' . $e->getMessage() . '</p></section>';
        }
        ?>
    </div>

<?php 
require_once __DIR__ . '/includes/footer.php';
?>
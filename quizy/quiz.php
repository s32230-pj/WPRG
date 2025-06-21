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

   
            $quiz_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

            $quiz_query = "SELECT title, description FROM quizzes WHERE id = ?";
            $quiz_stmt = $db->prepare($quiz_query);
            $quiz_stmt->execute([$quiz_id]);
            $quiz = $quiz_stmt->fetch(PDO::FETCH_ASSOC);

            if (!$quiz) {
                echo '<section class="section"><h2 class="section-title">Quiz nie znaleziony</h2><p>Przykro nam, ale ten quiz nie istnieje.</p></section>';
            } else {
                echo '
                <section class="section">
                    <h2 class="quiz-title">' . htmlspecialchars($quiz['title']) . '</h2>
                    <p>' . htmlspecialchars($quiz['description']) . '</p>
                </section>';


                $questions_query = "SELECT id, question_text FROM questions WHERE quiz_id = ?";
                $questions_stmt = $db->prepare($questions_query);
                $questions_stmt->execute([$quiz_id]);
                $questions = $questions_stmt->fetchAll(PDO::FETCH_ASSOC);

                if (empty($questions)) {
                    echo '<section class="section"><p>Brak pytań w tym quizie.</p></section>';
                } else {
                    echo '<form action="submit_quiz.php" method="post">';
                    echo '<input type="hidden" name="quiz_id" value="' . $quiz_id . '">';

                    foreach ($questions as $question) {
                        echo '
                        <section class="section question">
                            <div class="question-text">' . htmlspecialchars($question['question_text']) . '</div>
                            <div class="options">';

                        $options_query = "SELECT id, option_text FROM answer_options WHERE question_id = ?";
                        $options_stmt = $db->prepare($options_query);
                        $options_stmt->execute([$question['id']]);
                        $options = $options_stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($options as $option) {
                            echo '
                            <div class="option">
                                <input type="radio" id="option_' . $option['id'] . '" name="question_' . $question['id'] . '" value="' . $option['id'] . '">
                                <label for="option_' . $option['id'] . '">' . htmlspecialchars($option['option_text']) . '</label>
                            </div>';
                        }

                        echo '</div></section>';
                    }

                    echo '
                    <section class="section">
                        <button type="submit" class="submit-btn">Sprawdź odpowiedzi</button>
                    </section>
                    </form>';
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
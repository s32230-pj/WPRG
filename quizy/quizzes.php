<?php
$pageTitle = 'Strona Główna';
require_once __DIR__ . '/includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

?>

    <div class="container">
        <section class="section">
            <h2 class="section-title">Wszystkie quizy</h2>
            <div class="quiz-list">
                <?php
               
                $host = "localhost";
                $dbname = "quizyowszystkim";
                $username = "root";  
                $password = "";      
                try {
                    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  
                    $query = "SELECT id, title, description, category FROM quizzes";
                    $stmt = $db->query($query);
                    $quizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (empty($quizzes)) {
                        echo "<p>Brak quizów w bazie danych. Dodaj pierwszy quiz!</p>";
                    } else {
                        foreach ($quizzes as $quiz) {
                            echo '
                            <div class="quiz-card">
                                <span class="quiz-category">' . htmlspecialchars($quiz['category']) . '</span>
                                <h3 class="quiz-title">' . htmlspecialchars($quiz['title']) . '</h3>
                                <p class="quiz-description">' . htmlspecialchars($quiz['description']) . '</p>
                                <a href="quiz.php?id=' . $quiz['id'] . '" style="color: #4CAF50; text-decoration: none;">Rozwiąż quiz →</a>
                            </div>';
                        }
                    }
                } catch (PDOException $e) {
                    echo "<p>Błąd połączenia z bazą danych: " . $e->getMessage() . "</p>";
                }
                ?>
            </div>
        </section>
    </div>

<?php 
require_once __DIR__ . '/includes/footer.php';
?>
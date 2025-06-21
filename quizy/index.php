<?php
$pageTitle = 'Strona Główna';
require_once __DIR__ . '/includes/header.php';


$host = "localhost";
$dbname = "quizyowszystkim";
$username = "root";   
$password = "";       

$db = null; 

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {

    echo "<p>Błąd połączenia z bazą danych: " . $e->getMessage() . "</p>";

}

?>

<div class="container">
    <section class="section">
        <h2 class="section-title">Quiz dnia</h2>
        <?php
    
        if ($db) { 
            $quizDniaId = 5;

            $queryQuizDnia = "SELECT id, title, description, category FROM quizzes WHERE id = :id";
            $stmtQuizDnia = $db->prepare($queryQuizDnia);
            $stmtQuizDnia->bindParam(':id', $quizDniaId, PDO::PARAM_INT);
            $stmtQuizDnia->execute();
            $quizDnia = $stmtQuizDnia->fetch(PDO::FETCH_ASSOC);

            if ($quizDnia) {
                echo '
                <div class="quiz-card quiz-of-the-day">
                    <span class="quiz-category">' . htmlspecialchars($quizDnia['category']) . '</span>
                    <h3 class="quiz-title">' . htmlspecialchars($quizDnia['title']) . '</h3>
                    <p class="quiz-description">' . htmlspecialchars($quizDnia['description']) . '</p>
                    <a href="quiz.php?id=' . $quizDnia['id'] . '" style="color: #4CAF50; text-decoration: none;">Rozwiąż quiz dnia →</a>
                </div>';
            } else {
                echo "<p>Quiz dnia (ID: " . $quizDniaId . ") nie został znaleziony w bazie danych.</p>";
            }
        } else {
  
            echo "<p>Nie można wyświetlić quizu dnia z powodu problemów z bazą danych.</p>";
        }
        ?>
    </section>

    <section class="section">
        <h2 class="section-title">Najpopularniejsze quizy</h2>
        <p>Tutaj będzie lista quizów (np. TOP 5 najczęściej rozwiązywanych).</p>
    </section>
</div>

<?php 
require_once __DIR__ . '/includes/footer.php';
?>
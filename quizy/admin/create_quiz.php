<?php
$pageTitle = 'Dodaj nowy quiz';
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

?>

<div class="container">
    <section class="section">
        <h2 class="section-title">Dodaj nowy quiz</h2>
        
        <form action="process_quiz.php" method="POST" id="quiz-form">
            <div class="form-group">
                <label for="quiz-title">Tytuł quizu:</label>
                <input type="text" id="quiz-title" name="title" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="quiz-description">Opis:</label>
                <textarea id="quiz-description" name="description" class="form-control" rows="3"></textarea>
            </div>
            
            <div class="form-group">
                <label for="quiz-category">Kategoria:</label>
                <select id="quiz-category" name="category" class="form-control" required>
                    <option value="">Wybierz kategorię</option>
                    <option value="Historia">Historia</option>
                    <option value="Geografia">Geografia</option>
                    <option value="Nauka">Nauka</option>
                    <option value="Rozrywka">Rozrywka</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="quiz-type">Typ quizu:</label>
                <select id="quiz-type" name="type" class="form-control" required>
                    <option value="single_choice">Pojedynczy wybór</option>
                    <option value="multiple_choice">Wielokrotny wybór</option>
                    <option value="true_false">Prawda/Fałsz</option>
                </select>
            </div>
            
            <hr>
            
            <div id="questions-container">
             
                <div class="question-group" data-question-id="1">
                    <h3>Pytanie #1</h3>
                    
                    <div class="form-group">
                        <label>Treść pytania:</label>
                        <input type="text" name="questions[1][text]" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Odpowiedzi:</label>
                        <div class="answers-container">
                            <div class="answer-group">
                                <input type="text" name="questions[1][answers][1][text]" class="form-control" placeholder="Odpowiedź 1" required>
                                <label class="checkbox-label">
                                    <input type="checkbox" name="questions[1][answers][1][correct]"> Poprawna
                                </label>
                            </div>
                            <div class="answer-group">
                                <input type="text" name="questions[1][answers][2][text]" class="form-control" placeholder="Odpowiedź 2" required>
                                <label class="checkbox-label">
                                    <input type="checkbox" name="questions[1][answers][2][correct]"> Poprawna
                                </label>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary btn-sm add-answer">+ Dodaj odpowiedź</button>
                    </div>
                </div>
            </div>
            
            <button type="button" id="add-question" class="btn btn-secondary">+ Dodaj pytanie</button>
            <hr>
            <button type="submit" class="btn btn-primary">Zapisz quiz</button>
        </form>
    </section>
</div>

<script>

document.getElementById('add-question').addEventListener('click', function() {
    const questionId = Date.now();
    const questionHTML = `
        <div class="question-group" data-question-id="${questionId}">
            <h3>Pytanie #${document.querySelectorAll('.question-group').length + 1}</h3>
            <button type="button" class="btn btn-danger btn-sm remove-question" style="float: right;">Usuń</button>
            
            <div class="form-group">
                <label>Treść pytania:</label>
                <input type="text" name="questions[${questionId}][text]" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label>Odpowiedzi:</label>
                <div class="answers-container">
                    <div class="answer-group">
                        <input type="text" name="questions[${questionId}][answers][1][text]" class="form-control" placeholder="Odpowiedź 1" required>
                        <label class="checkbox-label">
                            <input type="checkbox" name="questions[${questionId}][answers][1][correct]"> Poprawna
                        </label>
                    </div>
                    <div class="answer-group">
                        <input type="text" name="questions[${questionId}][answers][2][text]" class="form-control" placeholder="Odpowiedź 2" required>
                        <label class="checkbox-label">
                            <input type="checkbox" name="questions[${questionId}][answers][2][correct]"> Poprawna
                        </label>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary btn-sm add-answer">+ Dodaj odpowiedź</button>
            </div>
        </div>
    `;
    document.getElementById('questions-container').insertAdjacentHTML('beforeend', questionHTML);
});


document.addEventListener('click', function(e) {
    if (e.target.classList.contains('add-answer')) {
        const questionId = e.target.closest('.question-group').dataset.questionId;
        const answerId = Date.now();
        const answerHTML = `
            <div class="answer-group">
                <input type="text" name="questions[${questionId}][answers][${answerId}][text]" class="form-control" placeholder="Nowa odpowiedź" required>
                <label class="checkbox-label">
                    <input type="checkbox" name="questions[${questionId}][answers][${answerId}][correct]"> Poprawna
                </label>
                <button type="button" class="btn btn-danger btn-sm remove-answer">Usuń</button>
            </div>
        `;
        e.target.previousElementSibling.insertAdjacentHTML('beforeend', answerHTML);
    }
    
    if (e.target.classList.contains('remove-question')) {
        e.target.closest('.question-group').remove();
    
        document.querySelectorAll('.question-group h3').forEach((el, index) => {
            el.textContent = `Pytanie #${index + 1}`;
        });
    }
    
    if (e.target.classList.contains('remove-answer')) {
        e.target.closest('.answer-group').remove();
    }
});
</script>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
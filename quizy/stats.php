<?php
$pageTitle = 'Statystyki';
require_once __DIR__ . '/includes/header.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


require_once __DIR__ . '/config/db.php';
$pdo = getDbConnection();
?>

<div class="container">
    <div class="section">
        <h1 class="section-title">Statystyki systemu</h1>
        
        <div class="stats-grid">

            <div class="stat-card">
                <div class="stat-value">
                    <?php
                    $stmt = $pdo->query("SELECT COUNT(*) FROM users");
                    echo $stmt->fetchColumn();
                    ?>
                </div>
                <div class="stat-label">Zarejestrowanych użytkowników</div>
            </div>

            <div class="stat-card">
                <div class="stat-value">
                    <?php
                    $stmt = $pdo->query("SELECT COUNT(*) FROM quizzes");
                    echo $stmt->fetchColumn();
                    ?>
                </div>
                <div class="stat-label">Utworzonych quizów</div>
            </div>
            
   
            <div class="stat-card">
                <div class="stat-value">
                    <?php
                    $stmt = $pdo->query("SELECT COUNT(*) FROM questions");
                    echo $stmt->fetchColumn();
                    ?>
                </div>
                <div class="stat-label">Pytań w systemie</div>
            </div>
        </div>
    </div>
    
    <div class="section">
        <h2 class="section-title">Najpopularniejsze quizy</h2>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tytuł quizu</th>
                        <th>Kategoria</th>
                        <th>Liczba rozwiązań</th>
                        <th>Średni wynik</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $pdo->query("
                        SELECT q.id, q.title, q.category, 
                               COUNT(s.quiz_id) as attempts,
                               AVG(s.score) as avg_score
                        FROM quizzes q
                        LEFT JOIN user_stats s ON q.id = s.quiz_id
                        GROUP BY q.id
                        ORDER BY attempts DESC
                        LIMIT 5
                    ");
                    
                    $i = 1;
                    while ($row = $stmt->fetch()):
                    ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= htmlspecialchars($row['title']) ?></td>
                        <td><?= htmlspecialchars($row['category']) ?></td>
                        <td><?= $row['attempts'] ?: '0' ?></td>
                        <td><?= $row['avg_score'] ? round($row['avg_score'], 2) . '%' : 'Brak danych' ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <?php if ($_SESSION['role'] === 'admin'): ?>
    <div class="section">
        <h2 class="section-title">Ostatnie aktywności</h2>
        <div class="logs-container">
            <?php
            $stmt = $pdo->query("
                SELECT * FROM logs 
                ORDER BY created_at DESC 
                LIMIT 10
            ");
            
            while ($log = $stmt->fetch()):
                $logClass = '';
                if (strpos($log['action'], 'error') !== false) {
                    $logClass = 'log-error';
                } elseif (strpos($log['action'], 'warning') !== false) {
                    $logClass = 'log-warning';
                }
            ?>
            <div class="log-entry <?= $logClass ?>">
                <strong>[<?= $log['created_at'] ?>]</strong> 
                <?= htmlspecialchars($log['action']) ?> 
                <small>(<?= $log['user_id'] ?>)</small>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php 
require_once __DIR__ . '/includes/footer.php';
?>
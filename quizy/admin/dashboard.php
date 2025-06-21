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


try {

    $quizzes_count = $db->query("SELECT COUNT(*) FROM quizzes")->fetchColumn();

    $users_count = $db->query("SELECT COUNT(*) FROM users")->fetchColumn();

    $recent_quizzes = $db->query("
        SELECT q.id, q.title, q.category, u.username as author, q.created_at 
        FROM quizzes q
        LEFT JOIN users u ON q.created_by = u.id
        ORDER BY q.created_at DESC 
        LIMIT 5
    ")->fetchAll(PDO::FETCH_ASSOC);
    

    $logs = [
        ['type' => 'info', 'message' => 'Admin zalogowany', 'time' => date('Y-m-d H:i:s')],
        ['type' => 'warning', 'message' => 'Próba logowania użytkownika do panelu administratora...', 'time' => date('Y-m-d H:i:s', time()-2)],
    ];

} catch (PDOException $e) {
    die("Błąd bazy danych: " . $e->getMessage());
}
?>



    <div class="container">
        <h1>Panel administracyjny</h1>
        
      
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-value"><?php echo $quizzes_count; ?></div>
                <div class="stat-label">Quizy</div>
            </div>
            <div class="stat-card">
                <div class="stat-value"><?php echo $users_count; ?></div>
                <div class="stat-label">Użytkownicy</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">-</div>
                <div class="stat-label">Aktywni dziś</div>
            </div>
        </div>

   
        <section class="section">
            <h2 class="section-title">Ostatnio dodane quizy</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tytuł</th>
                        <th>Kategoria</th>
                        <th>Autor</th>
                        <th>Data</th>
                        <th>Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recent_quizzes as $quiz): ?>
                    <tr>
                        <td><?php echo $quiz['id']; ?></td>
                        <td><?php echo htmlspecialchars($quiz['title']); ?></td>
                        <td><span class="badge"><?php echo htmlspecialchars($quiz['category']); ?></span></td>
                        <td><?php echo htmlspecialchars($quiz['author'] ?? 'System'); ?></td>
                        <td><?php echo date('d.m.Y', strtotime($quiz['created_at'])); ?></td>
                        <td>
                            <a href="edit_quiz.php?id=<?php echo $quiz['id']; ?>" class="btn">Edytuj</a>
                            <form method="POST" action="/quizy/admin/delete_quiz.php" onsubmit="return confirm('Czy na pewno chcesz usunąć quiz?')">
    <input type="hidden" name="quiz_id" value="<?= $quiz['id'] ?>">
    <button type="submit" class="btn btn-danger">Usuń quiz</button>
</form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>


        <section class="section">
            <h2 class="section-title">Logi systemowe</h2>
            <div style="max-height: 300px; overflow-y: auto;">
                <?php foreach ($logs as $log): ?>
                <div class="log-entry <?php echo $log['type'] === 'warning' ? 'log-warning' : ($log['type'] === 'error' ? 'log-error' : ''); ?>">
                    <strong>[<?php echo $log['time']; ?>]</strong> 
                    <?php echo htmlspecialchars($log['message']); ?>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="section">
            <h2 class="section-title">Szybkie akcje</h2>
            <div style="display: flex; gap: 1rem;">
                <a href="create_quiz.php" class="btn">Dodaj quiz</a>
                <a href="manage_users.php" class="btn">Zarządzaj użytkownikami</a>
                <a href="export_data.php" class="btn">Eksportuj dane</a>
            </div>
        </section>
    </div>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
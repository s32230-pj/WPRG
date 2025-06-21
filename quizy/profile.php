<?php
$pageTitle = 'Strona Główna';
require_once __DIR__ . '/includes/header.php';
?>


<?php

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$host = "localhost";
$dbname = "quizyowszystkim";
$db_username = "root";
$db_password = "";

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $db_username, $db_password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $user_query = "SELECT username, email, role, created_at FROM users WHERE id = ?";
    $stmt = $db->prepare($user_query);
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $stats_query = "SELECT COUNT(*) as total_quizzes, AVG(score) as avg_score FROM user_stats WHERE user_id = ?";
    $stats_stmt = $db->prepare($stats_query);
    $stats_stmt->execute([$_SESSION['user_id']]);
    $stats = $stats_stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Błąd bazy danych: " . $e->getMessage());
}
?>


    <div class="container">
 
        <section class="section">
            <div class="profile-header">
                <img src="assets/default_avatar.png" alt="Avatar" class="avatar">
                <div class="user-info">
                    <h1>
                        <?php echo htmlspecialchars($user['username']); ?>
                        <?php if($user['role'] === 'admin'): ?>
                            <span class="admin-badge">Administrator</span>
                        <?php endif; ?>
                    </h1>
                    <div class="user-meta">
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                        <p><strong>Dołączył:</strong> <?php echo date('d.m.Y', strtotime($user['created_at'])); ?></p>
                    </div>
                </div>
            </div>
        </section>

        <section class="section">
            <h2 class="section-title">Twoje statystyki</h2>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-value"><?php echo $stats['total_quizzes'] ?? 0; ?></div>
                    <div class="stat-label">Rozwiązane quizy</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?php echo isset($stats['avg_score']) ? round($stats['avg_score'], 1) : '0'; ?>%</div>
                    <div class="stat-label">Średni wynik</div>
                </div>
            </div>
        </section>


        <?php if($user['role'] === 'admin'): ?>
        <section class="section">
            <h2 class="section-title">Panel administratora</h2>
            <a href="admin/dashboard.php" class="btn">Panel administracyjny</a>
            <a href="admin/create_quiz.php" class="btn">Dodaj quiz</a>
        </section>
        <?php endif; ?>
    </div>

<?php 
require_once __DIR__ . '/includes/footer.php';
?>
<?php require_once __DIR__ . '/init.php';
$baseUrl = '/quizy'; ?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'QuizyOWszystkim'; ?></title>
    <link rel="stylesheet" href="<?php echo dirname($_SERVER['PHP_SELF']) === '/quizy' ? 'css/styles.css' : '../css/styles.css'; ?>">
</head>
<body>
    <nav class="navbar">
        <a href="<?php echo $baseUrl; ?>/index.php" class="navbar-brand">QuizyOWszystkim</a>
    <div class="navbar-menu">
        <a href="<?php echo $baseUrl; ?>/index.php">Strona Główna</a>
        <a href="<?php echo $baseUrl; ?>/quizzes.php">Lista Quizów</a>
        <a href="<?php echo $baseUrl; ?>/stats.php">Statystyki</a>
            <a href="<?php echo $baseUrl; ?>/profile.php">Profil</a>
            <?php if(isLoggedIn()): ?>
                <a href="<?php echo $baseUrl; ?>/logout.php" class="logout-btn">
                    Wyloguj (<?php echo htmlspecialchars($_SESSION['username']); ?>)
                </a>
            <?php else: ?>
                <a href="<?php echo $baseUrl; ?>/login.php" class="login-btn">Zaloguj się</a>
            <?php endif; ?>
        </div>
    </nav>

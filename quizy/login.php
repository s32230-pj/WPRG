<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: profile.php");
    exit();
}

$host = "localhost";
$dbname = "quizyowszystkim";
$db_username = "root";
$db_password = "";

$error = '';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $db_username, $db_password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

      
        if (empty($username) || empty($password)) {
            $error = 'Wszystkie pola są wymagane';
        } else {
        
            $query = "SELECT id, username, password_hash, role FROM users WHERE username = :username";
            $stmt = $db->prepare($query);
            $stmt->execute([':username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password_hash'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role']; 
                
                echo "<pre>Sesja po zalogowaniu: ";
                print_r($_SESSION);
                echo "</pre>";
                
                header("Location: profile.php");
                exit();
            } else {
                $error = 'Nieprawidłowa nazwa użytkownika lub hasło';
            }
        }
    }
} catch (PDOException $e) {
    $error = 'Błąd bazy danych: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie | QuizyOWszystkim</title>
 <link rel="stylesheet" href="/quizy/css/styles.css">
</head>
<body>

    <nav class="navbar">
        <a href="index.php" class="navbar-brand">QuizyOWszystkim</a>
        <div class="navbar-menu">
            <a href="index.php">Strona Główna</a>
            <a href="quizzes.php">Lista Quizów</a>
            <a href="stats.php">Statystyki</a>
            <a href="<?php echo isset($_SESSION['user_id']) ? 'profile.php' : 'login.php'; ?>">Profil</a>
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="logout.php" class="login-btn" style="background-color: #f44336;">
                    Wyloguj (<?php echo htmlspecialchars($_SESSION['username']); ?>)
                </a>
            <?php else: ?>
                <a href="login.php" class="login-btn">Zaloguj</a>
            <?php endif; ?>
        </div>
    </nav>


    <div class="container">
        <section class="section">
            <h2 class="section-title">Logowanie</h2>
            
            <?php if ($error): ?>
                <div class="error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <form method="POST" action="login.php">
                <div class="form-group">
                    <label for="username">Nazwa użytkownika:</label>
                    <input type="text" id="username" name="username" required
                           value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="password">Hasło:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit" class="btn">Zaloguj się</button>
                
                <div class="links">
                    <p>Nie masz konta? <a href="register.php">Zarejestruj się</a></p>
                    <p><a href="forgot_password.php">Zapomniałeś hasła?</a></p>
                </div>
            </form>
        </section>
    </div
<?php 
require_once __DIR__ . '/includes/footer.php';
?>
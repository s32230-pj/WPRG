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
$success = '';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $db_username, $db_password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $confirm_password = trim($_POST['confirm_password']);


        if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
            $error = 'Wszystkie pola są wymagane';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Nieprawidłowy format email';
        } elseif ($password !== $confirm_password) {
            $error = 'Hasła nie są identyczne';
        } elseif (strlen($password) < 8) {
            $error = 'Hasło musi mieć co najmniej 8 znaków';
        } else {
      
            $check_query = "SELECT id FROM users WHERE username = :username OR email = :email";
            $stmt = $db->prepare($check_query);
            $stmt->execute([':username' => $username, ':email' => $email]);

            if ($stmt->rowCount() > 0) {
                $error = 'Nazwa użytkownika lub email już istnieje';
            } else {
       
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                $insert_query = "INSERT INTO users (username, email, password_hash) VALUES (:username, :email, :password_hash)";
                $stmt = $db->prepare($insert_query);
                $stmt->execute([
                    ':username' => $username,
                    ':email' => $email,
                    ':password_hash' => $password_hash
                ]);

                if ($stmt->rowCount() > 0) {
                    $success = 'Rejestracja udana! Możesz się teraz zalogować.';
                } else {
                    $error = 'Błąd podczas rejestracji';
                }
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
    <title>Rejestracja | QuizyOWszystkim</title>
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
            <h2 class="section-title">Rejestracja</h2>
            
            <?php if ($error): ?>
                <div class="error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="success"><?php echo htmlspecialchars($success); ?></div>
                <p><a href="login.php" class="btn">Przejdź do logowania</a></p>
            <?php else: ?>
                <form method="POST" action="register.php">
                    <div class="form-group">
                        <label for="username">Nazwa użytkownika:</label>
                        <input type="text" id="username" name="username" required 
                               value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required
                               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Hasło (min. 8 znaków):</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_password">Potwierdź hasło:</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>
                    </div>
                    
                    <button type="submit" class="btn">Zarejestruj się</button>
                </form>
                
                <p style="margin-top: 1rem;">Masz już konto? <a href="login.php">Zaloguj się</a></p>
            <?php endif; ?>
        </section>
    </div>

<?php 
require_once __DIR__ . '/includes/footer.php';
?>
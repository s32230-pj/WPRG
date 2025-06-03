<?php
session_start();


$valid_username = "admin";
$valid_password = "admin123";

// Obsługa logowania
if (isset($_POST['login']) && isset($_POST['password'])) {
    if ($_POST['login'] === $valid_username && $_POST['password'] === $valid_password) {
        $_SESSION['zalogowany'] = true;
        setcookie("login", $_POST['login'], time() + 86400); // zapamiętaj login na 1 dzień
        header("Location: index.php");
        exit();
    } else {
        $login_error = "Nieprawidłowy login lub hasło.";
    }
}


if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}


if (isset($_GET['clear'])) {
    foreach ($_COOKIE as $key => $value) {
        setcookie($key, '', time() - 3600);
    }
    header("Location: index.php");
    exit();
}

a
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['imie'])) {
    foreach ($_POST as $key => $value) {
        if (is_array($value)) continue;
        setcookie($key, $value, time() + 86400);
    }
}

$form_data = [];
foreach ($_COOKIE as $key => $value) {
    $form_data[$key] = $value;
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Hotel - Rezerwacja</title>
</head>
<body>

<?php if (!isset($_SESSION['zalogowany'])): ?>
    <h1>Logowanie</h1>
    <?php if (isset($login_error)) echo "<p style='color:red;'>$login_error</p>"; ?>
    <form method="post">
        <label>Login: <input type="text" name="login" required></label><br><br>
        <label>Hasło: <input type="password" name="password" required></label><br><br>
        <button type="submit">Zaloguj</button>
    </form>
    <p style="color:gray;">Musisz być zalogowany, aby móc dokonać rezerwacji.</p>

<?php else: ?>
    <p>Witaj, <strong><?php echo $_COOKIE['login'] ?? 'użytkowniku'; ?></strong>! <a href="?logout=1">[Wyloguj się]</a></p>
    <a href="?clear=1">[Wyczyść formularz i usuń ciasteczka]</a>

    <h1>Formularz Rezerwacji Hotelu</h1>

    <?php
    $ilosc_osob = $_POST['ilosc_osob'] ?? ($_COOKIE['ilosc_osob'] ?? 1);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['imie'])) {
        $imie = $_POST['imie'];
        $nazwisko = $_POST['nazwisko'];
        $adres = $_POST['adres'];
        $email = $_POST['email'];
        $karta_kr = $_POST['karta_kr'];
        $data_pobytu = $_POST['data_pobytu'];
        $godzina_przyjazdu = $_POST['godzina_przyjazdu'];
        $lozko_dla_dziecka = isset($_POST['lozko_dla_dziecka']) ? 'Tak' : 'Nie';
        $udogodnienia = isset($_POST['udogodnienia']) ? implode(", ", $_POST['udogodnienia']) : 'Brak';

        $osoby = [];
        for ($i = 2; $i <= $ilosc_osob; $i++) {
            $osoby[] = [
                'imie' => $_POST["imie_osoba$i"] ?? '',
                'nazwisko' => $_POST["nazwisko_osoba$i"] ?? '',
                'wiek' => $_POST["wiek_osoba$i"] ?? '',
            ];
        }

        $blad = false;
        if (empty($imie) || empty($nazwisko) || empty($adres) || empty($email) || empty($karta_kr) || empty($data_pobytu) || empty($godzina_przyjazdu)) {
            $blad = true;
            echo "<p style='color:red;'>Wszystkie pola są wymagane!</p>";
        }

        if (!$blad) {
            $csv_file = 'rezerwacje.csv';
            $rezerwacja = [
                $imie, $nazwisko, $adres, $email, $karta_kr, $ilosc_osob,
                $data_pobytu, $godzina_przyjazdu, $lozko_dla_dziecka, $udogodnienia,
                json_encode($osoby)
            ];
            $file = fopen($csv_file, file_exists($csv_file) ? 'a' : 'w');
            if (filesize($csv_file) === 0) {
                fputcsv($file, ['Imię', 'Nazwisko', 'Adres', 'Email', 'Karta kredytowa', 'Ilość osób', 'Data pobytu', 'Godzina przyjazdu', 'Łóżko dla dziecka', 'Udogodnienia', 'Osoby']);
            }
            fputcsv($file, $rezerwacja);
            fclose($file);

            echo "<h2>Podsumowanie Rezerwacji</h2>";
            echo "<p><strong>Imię:</strong> $imie</p>";
            echo "<p><strong>Nazwisko:</strong> $nazwisko</p>";
            echo "<p><strong>Adres:</strong> $adres</p>";
            echo "<p><strong>Email:</strong> $email</p>";
            echo "<p><strong>Karta kredytowa:</strong> $karta_kr</p>";
            echo "<p><strong>Data pobytu:</strong> $data_pobytu</p>";
            echo "<p><strong>Godzina przyjazdu:</strong> $godzina_przyjazdu</p>";
            echo "<p><strong>Łóżko dla dziecka:</strong> $lozko_dla_dziecka</p>";
            echo "<p><strong>Udogodnienia:</strong> $udogodnienia</p>";
            foreach ($osoby as $i => $osoba) {
                echo "<p><strong>Osoba " . ($i + 2) . ":</strong> " . $osoba['imie'] . " " . $osoba['nazwisko'] . ", wiek: " . $osoba['wiek'] . "</p>";
            }
            echo "<hr>";
        }
    }
    ?>

    <form method="post">
        <label>Imię:</label><input type="text" name="imie" value="<?php echo $_POST['imie'] ?? $form_data['imie'] ?? ''; ?>" required><br><br>
        <label>Nazwisko:</label><input type="text" name="nazwisko" value="<?php echo $_POST['nazwisko'] ?? $form_data['nazwisko'] ?? ''; ?>" required><br><br>
        <label>Adres:</label><input type="text" name="adres" value="<?php echo $_POST['adres'] ?? $form_data['adres'] ?? ''; ?>" required><br><br>
        <label>Email:</label><input type="email" name="email" value="<?php echo $_POST['email'] ?? $form_data['email'] ?? ''; ?>" required><br><br>
        <label>Karta kredytowa:</label><input type="text" name="karta_kr" value="<?php echo $_POST['karta_kr'] ?? $form_data['karta_kr'] ?? ''; ?>" required><br><br>

        <label>Ilość osób:</label>
        <select name="ilosc_osob" onchange="this.form.submit()">
            <?php for ($i = 1; $i <= 4; $i++): ?>
                <option value="<?php echo $i; ?>" <?php if ($ilosc_osob == $i) echo 'selected'; ?>><?php echo $i; ?></option>
            <?php endfor; ?>
        </select><br><br>

        <label>Data pobytu:</label><input type="date" name="data_pobytu" value="<?php echo $_POST['data_pobytu'] ?? $form_data['data_pobytu'] ?? ''; ?>" required><br><br>
        <label>Godzina przyjazdu:</label><input type="time" name="godzina_przyjazdu" value="<?php echo $_POST['godzina_przyjazdu'] ?? $form_data['godzina_przyjazdu'] ?? ''; ?>" required><br><br>

        <label><input type="checkbox" name="lozko_dla_dziecka" <?php echo isset($_POST['lozko_dla_dziecka']) || isset($form_data['lozko_dla_dziecka']) ? 'checked' : ''; ?>> Łóżko dla dziecka</label><br><br>

        <label>Udogodnienia:</label><br>
        <input type="checkbox" name="udogodnienia[]" value="Klimatyzacja" <?php echo (isset($_POST['udogodnienia']) && in_array('Klimatyzacja', $_POST['udogodnienia'])) ? 'checked' : ''; ?>> Klimatyzacja<br>
        <input type="checkbox" name="udogodnienia[]" value="Popielniczka dla palacza" <?php echo (isset($_POST['udogodnienia']) && in_array('Popielniczka dla palacza', $_POST['udogodnienia'])) ? 'checked' : ''; ?>> Popielniczka<br><br>

        <?php
        for ($i = 2; $i <= $ilosc_osob; $i++) {
            echo "<h4>Osoba $i</h4>";
            echo "<label>Imię:</label><input type='text' name='imie_osoba$i' value='" . ($_POST["imie_osoba$i"] ?? '') . "' required><br><br>";
            echo "<label>Nazwisko:</label><input type='text' name='nazwisko_osoba$i' value='" . ($_POST["nazwisko_osoba$i"] ?? '') . "' required><br><br>";
            echo "<label>Wiek:</label><input type='number' name='wiek_osoba$i' value='" . ($_POST["wiek_osoba$i"] ?? '') . "' required><br><br>";
        }
        ?>
        <button type="submit">Zarezerwuj</button>
    </form>
<?php endif; ?>

</body>
</html>

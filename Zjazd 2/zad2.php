<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dane osoby rezerwującej
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $adres = $_POST['adres'];
    $email = $_POST['email'];
    $karta_kr = $_POST['karta_kr'];
    $ilosc_osob = $_POST['ilosc_osob'];
    $data_pobytu = $_POST['data_pobytu'];
    $godzina_przyjazdu = $_POST['godzina_przyjazdu'];
    $lozko_dla_dziecka = isset($_POST['lozko_dla_dziecka']) ? 'Tak' : 'Nie';
    $udogodnienia = isset($_POST['udogodnienia']) ? implode(", ", $_POST['udogodnienia']) : 'Brak';

    $osoby = [];
    if ($ilosc_osob > 0) {
        // Dane dla dodatkowych osób (pomijamy osobę rezerwującą)
        for ($i = 2; $i <= $ilosc_osob; $i++) {
            if (isset($_POST['imie_osoba' . $i])) {
                $osoby[] = [
                    'imie' => $_POST['imie_osoba' . $i],
                    'nazwisko' => $_POST['nazwisko_osoba' . $i],
                    'wiek' => $_POST['wiek_osoba' . $i]
                ];
            }
        }
    }

    $blad = false;
    if (empty($imie) || empty($nazwisko) || empty($adres) || empty($email) || empty($karta_kr) || empty($data_pobytu) || empty($godzina_przyjazdu)) {
        $blad = true;
        $blad_komunikat = "Wszystkie pola są wymagane!";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rezerwacja Hotelu</title>
</head>
<body>

<h1>Formularz Rezerwacji Hotelu</h1>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && !$blad) {
    echo "<h2>Podsumowanie Rezerwacji</h2>";
    echo "<p><strong>Imię:</strong> $imie</p>";
    echo "<p><strong>Nazwisko:</strong> $nazwisko</p>";
    echo "<p><strong>Adres:</strong> $adres</p>";
    echo "<p><strong>E-mail:</strong> $email</p>";
    echo "<p><strong>Dane karty kredytowej:</strong> $karta_kr</p>";
    echo "<p><strong>Ilość osób:</strong> $ilosc_osob</p>";
    echo "<p><strong>Data pobytu:</strong> $data_pobytu</p>";
    echo "<p><strong>Godzina przyjazdu:</strong> $godzina_przyjazdu</p>";
    echo "<p><strong>Łóżko dla dziecka:</strong> $lozko_dla_dziecka</p>";
    echo "<p><strong>Udogodnienia:</strong> $udogodnienia</p>";
    
    echo "<h3>Dane osób:</h3>";
    echo "<p><strong>Osoba 1 (rezerwująca):</strong></p>";
    echo "<p>Imię: $imie</p>";
    echo "<p>Nazwisko: $nazwisko</p>";

    // Wyświetlanie danych dodatkowych osób
    foreach ($osoby as $index => $osoba) {
        echo "<p><strong>Osoba " . ($index + 2) . ":</strong></p>";
        echo "<p>Imię: " . $osoba['imie'] . "</p>";
        echo "<p>Nazwisko: " . $osoba['nazwisko'] . "</p>";
        echo "<p>Wiek: " . $osoba['wiek'] . "</p>";
    }
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && $blad) {
        echo "<p style='color: red;'>$blad_komunikat</p>";
    }
?>

<form method="post">
    <label for="imie">Imię (Osoba 1):</label>
    <input type="text" id="imie" name="imie" value="<?php echo $_POST['imie'] ?? ''; ?>" required><br><br>

    <label for="nazwisko">Nazwisko (Osoba 1):</label>
    <input type="text" id="nazwisko" name="nazwisko" value="<?php echo $_POST['nazwisko'] ?? ''; ?>" required><br><br>

    <label for="adres">Adres:</label>
    <input type="text" id="adres" name="adres" value="<?php echo $_POST['adres'] ?? ''; ?>" required><br><br>

    <label for="email">E-mail:</label>
    <input type="email" id="email" name="email" value="<?php echo $_POST['email'] ?? ''; ?>" required><br><br>

    <label for="karta_kr">Dane karty kredytowej:</label>
    <input type="text" id="karta_kr" name="karta_kr" value="<?php echo $_POST['karta_kr'] ?? ''; ?>" required><br><br>

    <label for="ilosc_osob">Ilość osób:</label>
    <select name="ilosc_osob" id="ilosc_osob" required onchange="this.form.submit()">
        <option value="1" <?php echo ($_POST['ilosc_osob'] == '1') ? 'selected' : ''; ?>>1</option>
        <option value="2" <?php echo ($_POST['ilosc_osob'] == '2') ? 'selected' : ''; ?>>2</option>
        <option value="3" <?php echo ($_POST['ilosc_osob'] == '3') ? 'selected' : ''; ?>>3</option>
        <option value="4" <?php echo ($_POST['ilosc_osob'] == '4') ? 'selected' : ''; ?>>4</option>
    </select><br><br>

    <label for="data_pobytu">Data pobytu:</label>
    <input type="date" id="data_pobytu" name="data_pobytu" value="<?php echo $_POST['data_pobytu'] ?? ''; ?>" required><br><br>

    <label for="godzina_przyjazdu">Godzina przyjazdu:</label>
    <input type="time" id="godzina_przyjazdu" name="godzina_przyjazdu" value="<?php echo $_POST['godzina_przyjazdu'] ?? ''; ?>" required><br><br>

    <label for="lozko_dla_dziecka">Czy potrzeba łóżko dla dziecka?</label>
    <input type="checkbox" id="lozko_dla_dziecka" name="lozko_dla_dziecka" <?php echo (isset($_POST['lozko_dla_dziecka']) ? 'checked' : ''); ?>><br><br>

    <label for="udogodnienia">Udogodnienia:</label><br>
    <input type="checkbox" name="udogodnienia[]" value="Klimatyzacja" <?php echo (isset($_POST['udogodnienia']) && in_array('Klimatyzacja', $_POST['udogodnienia'])) ? 'checked' : ''; ?>> Klimatyzacja<br>
    <input type="checkbox" name="udogodnienia[]" value="Popielniczka dla palacza" <?php echo (isset($_POST['udogodnienia']) && in_array('Popielniczka dla palacza', $_POST['udogodnienia'])) ? 'checked' : ''; ?>> Popielniczka dla palacza<br><br>

    <?php
    // Dodanie formularzy dla dodatkowych osób
    if (isset($_POST['ilosc_osob']) && $_POST['ilosc_osob'] > 1) {
        $ilosc_osob = $_POST['ilosc_osob'];
        for ($i = 2; $i <= $ilosc_osob; $i++) {
            echo "<h4>Osoba $i</h4>";
            echo "<label for='imie_osoba$i'>Imię:</label><input type='text' name='imie_osoba$i' value='" . ($_POST['imie_osoba' . $i] ?? '') . "' required><br><br>";
            echo "<label for='nazwisko_osoba$i'>Nazwisko:</label><input type='text' name='nazwisko_osoba$i' value='" . ($_POST['nazwisko_osoba' . $i] ?? '') . "' required><br><br>";
            echo "<label for='wiek_osoba$i'>Wiek:</label><input type='number' name='wiek_osoba$i' value='" . ($_POST['wiek_osoba' . $i] ?? '') . "' required><br><br>";
        }
    }
    ?>

    <button type="submit">Zatwierdź Rezerwację</button>
</form>

<?php
}
?>

</body>
</html>

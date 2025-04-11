<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $liczba = $_POST['liczba'];
    $blad = false;
    $iteracje = 0;

    if (!is_numeric($liczba) || $liczba <= 0 || $liczba != round($liczba)) {
        $blad = true;
        $blad_komunikat = "Proszę podać liczbę całkowitą dodatnią!";
    }

    function czyPierwsza($liczba, &$iteracje) {
        if ($liczba <= 1) return false;

        if ($liczba == 2) {
            $iteracje++;
            return true;
        }

        if ($liczba % 2 == 0) {
            $iteracje++;
            return false;
        }

        for ($i = 3; $i <= sqrt($liczba); $i += 2) {
            $iteracje++;
            if ($liczba % $i == 0) {
                return false;
            }
        }
        return true;
    }

    if (!$blad) {
        $wynik = czyPierwsza($liczba, $iteracje) ? "Liczba jest pierwsza." : "Liczba nie jest pierwsza.";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sprawdzenie Liczby Pierwszej</title>
</head>
<body>

<h1>Formularz Sprawdzania Liczby Pierwszej</h1>

<form method="post">
    <label for="liczba">Podaj liczbę:</label>
    <input type="number" name="liczba" required><br><br>
    <button type="submit">Sprawdź</button>
</form>

<?php
if (isset($blad_komunikat)) {
    echo "<p style='color: red;'>$blad_komunikat</p>";
} elseif (isset($wynik)) {
    echo "<p>$wynik</p>";
    echo "<p>Iteracje: $iteracje</p>";
}
?>

</body>
</html>

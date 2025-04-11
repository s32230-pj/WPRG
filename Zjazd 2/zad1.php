<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $liczba1 = $_POST['liczba1'];
    $liczba2 = $_POST['liczba2'];
    $dzialanie = $_POST['dzialanie'];
    $wynik = "";

    if ($dzialanie == "dodawanie") {
        $wynik = $liczba1 + $liczba2;
    } elseif ($dzialanie == "odejmowanie") {
        $wynik = $liczba1 - $liczba2;
    } elseif ($dzialanie == "mnozenie") {
        $wynik = $liczba1 * $liczba2;
    } elseif ($dzialanie == "dzielenie") {
        if ($liczba2 != 0) {
            $wynik = $liczba1 / $liczba2;
        } else {
            $wynik = "Nie mozna dzielic przez zero!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator</title>
</head>
<body>
    <h1>Prosty Kalkulator</h1>
    <form method="post">
        <label for="liczba1">Pierwsza liczba:</label>
        <input type="number" name="liczba1" id="liczba1" required><br><br>

        <label for="liczba2">Druga liczba:</label>
        <input type="number" name="liczba2" id="liczba2" required><br><br>

        <label for="dzialanie">Wybierz działanie:</label>
        <select name="dzialanie" id="dzialanie" required>
            <option value="dodawanie">Dodawanie</option>
            <option value="odejmowanie">Odejmowanie</option>
            <option value="mnozenie">Mnożenie</option>
            <option value="dzielenie">Dzielenie</option>
        </select><br><br>

        <button type="submit">Oblicz</button>
    </form>

    <?php
    if (isset($wynik)) {
        echo "<h2>Wynik: $wynik</h2>";
    }
    ?>
</body>
</html>

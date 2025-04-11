<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formularz Zapisujący Dane do Pliku</title>
</head>
<body>

<h1>Formularz Zapisujący Dane do Pliku</h1>

<form method="post" action="zapisz_dane.php">
    <label for="imie">Imię:</label>
    <input type="text" id="imie" name="imie" required><br><br>

    <label for="nazwisko">Nazwisko:</label>
    <input type="text" id="nazwisko" name="nazwisko" required><br><br>

    <label for="email">E-mail:</label>
    <input type="email" id="email" name="email" required><br><br>

    <button type="submit">Zapisz dane</button>
</form>

</body>
</html>

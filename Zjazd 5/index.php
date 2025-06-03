<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Portal z samochodami</title>
</head>
<body>

<table border="1" style="width: 100%; text-align: center;">
    <tr>
        <td><a href="index.php">Strona główna</a></td>
        <td><a href="?strona=wszystkie">Wszystkie samochody</a></td>
        <td><a href="?strona=dodaj">Dodaj samochód</a></td>
    </tr>
</table>

<?php
$conn = new mysqli("localhost", "root", "", "mojaBaza");

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $wynik = $conn->query("SELECT * FROM samochody WHERE id=$id");
    if ($sam = $wynik->fetch_assoc()) {
        echo "<h2>Szczegóły samochodu</h2>";
        echo "ID: " . $sam['id'] . "<br>";
        echo "Marka: " . $sam['marka'] . "<br>";
        echo "Model: " . $sam['model'] . "<br>";
        echo "Cena: " . $sam['cena'] . "<br>";
        echo "Rok: " . $sam['rok'] . "<br>";
        echo "Opis: " . $sam['opis'] . "<br><br>";
        echo "<a href='index.php'>Powrót</a>";
    } else {
        echo "Nie znaleziono samochodu.";
    }

} else if (isset($_GET['strona']) && $_GET['strona'] == 'wszystkie') {
    echo "<h2>Wszystkie samochody</h2>";
    $wynik = $conn->query("SELECT * FROM samochody ORDER BY rok DESC");
    echo "<table border='1'>
    <tr><th>ID</th><th>Marka</th><th>Model</th><th>Cena</th><th>Szczegóły</th></tr>";
    while ($sam = $wynik->fetch_assoc()) {
        echo "<tr>
            <td>" . $sam['id'] . "</td>
            <td>" . $sam['marka'] . "</td>
            <td>" . $sam['model'] . "</td>
            <td>" . $sam['cena'] . "</td>
            <td><a href='?id=" . $sam['id'] . "'>Szczegóły</a></td>
        </tr>";
    }
    echo "</table>";

} else if (isset($_GET['strona']) && $_GET['strona'] == 'dodaj') {
    echo "<h2>Dodaj samochód</h2>";
    echo '<form method="post">
        Marka: <input type="text" name="marka"><br>
        Model: <input type="text" name="model"><br>
        Cena: <input type="number" step="0.01" name="cena"><br>
        Rok: <input type="number" name="rok"><br>
        Opis: <textarea name="opis"></textarea><br>
        <input type="submit" name="dodaj" value="Dodaj">
    </form>';

    if (isset($_POST['dodaj'])) {
        $marka = $_POST['marka'];
        $model = $_POST['model'];
        $cena = $_POST['cena'];
        $rok = $_POST['rok'];
        $opis = $_POST['opis'];
        $conn->query("INSERT INTO samochody (marka, model, cena, rok, opis) VALUES ('$marka', '$model', $cena, $rok, '$opis')");
        echo "Samochód dodany.";
    }

} else {
    echo "<h2>Najtańsze samochody</h2>";
    $wynik = $conn->query("SELECT * FROM samochody ORDER BY cena ASC LIMIT 5");
    echo "<table border='1'>
    <tr><th>ID</th><th>Marka</th><th>Model</th><th>Cena</th></tr>";
    while ($sam = $wynik->fetch_assoc()) {
        echo "<tr>
            <td>" . $sam['id'] . "</td>
            <td>" . $sam['marka'] . "</td>
            <td>" . $sam['model'] . "</td>
            <td>" . $sam['cena'] . "</td>
        </tr>";
    }
    echo "</table>";
}

$conn->close();
?>

</body>
</html>

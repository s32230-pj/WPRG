<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $email = $_POST['email'];
    $dane = "Imię: $imie, Nazwisko: $nazwisko, E-mail: $email";
    $plik = "dane.txt";
    $plik_zapis = fopen($plik, "a");
    if ($plik_zapis) {
        fwrite($plik_zapis, $dane . PHP_EOL);
        fclose($plik_zapis);
        echo "Dane zostały zapisane!";
    } else {
        echo "Wystąpił błąd podczas zapisywania danych.";
    }
}
?>

<?php
function dodawanie($liczba1, $liczba2) {
    return $liczba1 + $liczba2;
}

function odejmowanie($liczba1, $liczba2) {
    return $liczba1 - $liczba2;
}

function mnozenie($liczba1, $liczba2) {
    return $liczba1 * $liczba2;
}

function dzielenie($liczba1, $liczba2) {
    if ($liczba2 != 0) {
        return $liczba1 / $liczba2;
    } else {
        return "Nie mozna dzielic przez zero!";
    }
}
?>

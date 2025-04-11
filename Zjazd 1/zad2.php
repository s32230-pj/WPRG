<?php
function czyPierwsza($liczba) {
    if ($liczba <= 1) {
        return false;
    }

    for ($i = 2; $i <= sqrt($liczba); $i++) {
        if ($liczba % $i == 0) {
            return false;
        }
    }

    return true;
}

$zakres_start = 1;
$zakres_koniec = 200;

for ($i = $zakres_start; $i <= $zakres_koniec; $i++) {
    if (czyPierwsza($i)) {
        echo $i . PHP_EOL;
    }
}
?>

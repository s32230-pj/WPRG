<?php
$N = 10;
$fibonacci = [0, 1];

for ($i = 2; $i <= $N; $i++) {
    $fibonacci[$i] = $fibonacci[$i - 1] + $fibonacci[$i - 2];
}

$liczba = 1;
foreach ($fibonacci as $liczbaF) {
    if ($liczbaF % 2 != 0) {
        echo $liczba . ". " . $liczbaF . PHP_EOL;
        $liczba++;
    }
}
?>

<?php
$owoce = ["gruszka", "winogrono", "truskawka", "pomarancza", "jagoda"];

foreach ($owoce as $owoc) {
    $odwrocony = '';
    $dlugosc = strlen($owoc);
    
    for ($i = $dlugosc - 1; $i >= 0; $i--) {
        $odwrocony .= $owoc[$i];
    }

    if (strtolower($owoc[0]) == 'p') {
        echo $odwrocony . " - Zaczyna sie na litere 'p'." . PHP_EOL;
    } else {
        echo $odwrocony . PHP_EOL;
    }
}
?>

<?php

$dataFromDatabase = [
    ['label' => 'January', 'value' => 10],
    ['label' => 'February', 'value' => 20],
    ['label' => 'March', 'value' => 15],
    // ...
];

$totalValue = 0;

foreach ($dataFromDatabase as $item) {
    $totalValue += $item['value'];
}


include base_path("views/dashboard/show.view.php");
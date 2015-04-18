<?php
require_once "Benchmark/Timer.php";

$timer = new Benchmark_Timer(TRUE);
// 自動モードに設定したので、ここから計測を開始します

$j = array();
for ($i = 0; $i < 100; $i++) {
    $j[] = $i;
    if ($i == 49)
        $timer->setMarker('Midway');
}


$timer->display();

// ここでタイマーが終了し、自動的に結果を表示します
?>
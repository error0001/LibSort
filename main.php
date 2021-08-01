<?php
set_time_limit(1000);
require_once 'BubbleSort.php';
$Sort = new Sort;
$array = $Sort->CreateRandomArray(0, 100);

$Sort->Log("\nOriginal Array :\n");
$Sort->Log(implode(', ',$array));
$Sort->Log("\nSorted Array:\n");
//$Sort->Log(implode(', ',$Sort->Bubble($array, 1)));
$Sort->Log(implode(', ',$Sort->Shaker($array)));
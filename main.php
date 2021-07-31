<?php
require_once 'BubbleSort.php';

$Sort = new Sort;
$array = $Sort->CreateRandomArray(0, 25);
$Sort->Log("\nOriginal Array :\n");
$Sort->Log(implode(', ',$array));
$Sort->Log("\nSorted Array:\n");
$Sort->Log(implode(', ',$Sort->Bubble($array, 1)));
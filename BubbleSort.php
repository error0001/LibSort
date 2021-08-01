<?php

class Sort
{
    public function __construct()
    {
        print_r(__METHOD__);
    }

    public function CreateRandomArray($min=0, $max=10)
    {
        $this->Log(__METHOD__);
        $random_number_array = range($min, $max);
        shuffle($random_number_array);
        return array_slice($random_number_array ,$min,$max);
    }

    public function Bubble($my_array, $reverse=false)
    {
        $this->Log(__METHOD__);
        if ($reverse) {
            do {
                // Флаг об окончании сортировки
                $swapped = false;
                for ($i = count($my_array) - 1, $c = 0; $i > $c; $i--) {
                    // В случае если элемент больше
                    if ($my_array[$i] > $my_array[$i - 1]) {
                        // Меняем местами значения используя конструкцию list
                        list($my_array[$i - 1], $my_array[$i]) = array($my_array[$i], $my_array[$i - 1]);
                        $swapped = true;
                    }
                }
            } while ($swapped); // В случае если сортировка прошла успешна, выходим из цикла}
        } else {
            do {
                // Флаг об окончании сортировки
                $swapped = false;
                for ($i = 0, $c = count($my_array) - 1; $i < $c; $i++) {
                    // В случае если элемент больше
                    if ($my_array[$i] > $my_array[$i + 1]) {
                        // Меняем местами значения используя конструкцию list
                        list($my_array[$i + 1], $my_array[$i]) = array($my_array[$i], $my_array[$i + 1]);
                        $swapped = true;
                    }
                }
            } while ($swapped); // В случае если сортировка прошла успешна, выходим из цикла}
        }
        return $my_array;
    }

    public function Shaker($values)
    {
        if (empty($values)) {
            return;
        }
        $left = 0;
        $right = count($values) - 1;
        while ($left <= $right) {
            for ($i = $right; $i > $left; --$i) {
                if ($values[$i - 1] > $values[$i]) {
                    list($values[$i - 1], $values[$i]) = array($values[$i], $values[$i - 1]);
                }
            }
            ++$left;
            for ($i = $left; $i < $right; ++$i) {
                if ($values[$i] > $values[$i + 1]) {
                    list($values[$i], $values[$i + 1]) =  array($values[$i + 1], $values[$i]);
                }
            }
            --$right;
        }
        return $values;
    }

    public function Log($value)
    {
        var_dump($value);
    }
}

/**
 * example run
 * $Sort = new Sort;
$array = $Sort->CreateRandomArray(0, 25);
$Sort->Log("\nOriginal Array :\n");
$Sort->Log(implode(', ',$array));
$Sort->Log("\nSorted Array:\n");
$Sort->Log(implode(', ',$Sort->Bubble($array, 1)));
 */

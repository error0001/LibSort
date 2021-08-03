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

    /**
     * Сортировка пузырьком - является основой для других сортирвок
     *
     * Не стоит использоваться на практике, так как он очень медленный
     *
     * Худший вариант по затратам по времени O(n^2)
     *
     * @param $my_array
     * @param false $reverse - дополнительно добавил реверс систему для наглядности
     * @return mixed
     */
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

    /**
     * Сортировка перемешиванием (шейкерная сортировка)
     *
     * двунаправленная: алгоритм перемещается не строго слева направо, а сначала слева направо, затем справа налево.
     *
     * Худший вариант по затратам по времени O(n^2)
     *
     * @param $values
     */
    public function Shaker($values)
    {
        if (empty($values)) {
            return;
        }
        $left = 0;
        $right = count($values) - 1;
        while ($left <= $right) {
            for ($i = $right; $i > $left; --$i) {
                // начинаем обработку с конца
                if ($values[$i - 1] > $values[$i]) {
                    // если число больше, то надо его свапнуть
                    list($values[$i - 1], $values[$i]) = array($values[$i], $values[$i - 1]);
                }
            }
            ++$left; // как только это будет больше чем инкремент вектора вправо прервется цикл
            for ($i = $left; $i < $right; ++$i) {
                if ($values[$i] > $values[$i + 1]) {
                    list($values[$i], $values[$i + 1]) =  array($values[$i + 1], $values[$i]);
                }
            }
            --$right; // как только это будет меньше чем инкремент вектора влево прервется цикл
        }
        return $values;
    }

    /**
     * Сортировка расчёской — улучшение сортировки пузырьком.
     * Её идея состоит в том, чтобы «устранить» элементы с небольшими
     * значения в конце массива, которые замедляют работу алгоритма.
     * Если при пузырьковой и шейкерной сортировках при переборе массива
     * сравниваются соседние элементы, то при «расчёсывании» сначала
     * берётся достаточно большое расстояние между сравниваемыми
     * значениями, а потом оно сужается вплоть до минимального.
     *
     * Сложность по времени
     * Худшее время:  O(n^2)
     * Среднее время: Омега(n^2/2p), где p - количество инкрементов
     * Лучшее время: O(n log n)
     *
     * время
     *
     * @param $values
     * @param float $factor - Фактор уменьшения
     * @return mixed
     */
    public function Comb($values, $factor = 1.247)
    {
        $step = count($values) - 1;

        while ($step >= 1) {
            for ($i = 0; $i + $step < count($values); ++$i) {
                if ($values[$i] > $values[$i + $step]) {
                    list($values[$i], $values[$i + $step]) = array($values[$i + $step], $values[$i]);
                }
            }
            $step /= $factor;
        }
        // сортировка пузырьком
        for ($idx_i = 0; $idx_i + 1 < count($values); ++$idx_i) {
            for ($idx_j = 0; $idx_j + 1 < count($values) - $idx_i; ++$idx_j) {
                if ($values[$idx_j + 1] < $values[$idx_j]) {
                    list($values[$idx_j], $values[$idx_j + 1]) = array($values[$idx_j + 1], $values[$idx_j]);
                }
            }
        }
        return $values;
    }

    /**
     * "Сортировка вставками"
     * При сортировке вставками массив постепенно перебирается
     * слева направо. При этом каждый последующий элемент
     * размещается так, чтобы он оказался между ближайшими
     * элементами с минимальным и максимальным значением.
     *
     * Худший вариант по затратам по времени O(n^2)
     * @param $values
     * @return mixed
     */
    public function Insertion($values)
    {
        for ($i = 1; $i < count($values); ++$i) {
            $x = $values[$i]; // запоминаем значение
            $j = $i; // запоминаем где находится значение
            // начинаем с конца искать значение пока оно больше чем временное
            while ($j > 0 && $values[$j - 1] > $x) {
                $values[$j] = $values[$j - 1]; // меняем местами, так каждый раз мы уменьшаем наш индекс
                --$j; // смещаемся на 1 каждый раз когда переставили
            }
            $values[$j] = $x; // замена произведена
        }
        return $values;
    }


    /**
     * Сортировка выбором
     *
     * Сначала нужно рассмотреть подмножество массива
     * и найти в нём максимум (или минимум). Затем выбранное значение
     * меняют местами со значением первого неотсортированного элемента.
     * Этот шаг нужно повторять до тех пор, пока в массиве
     * не закончатся неотсортированные подмассивы.
     *
     * @param $values
     * @return mixed
     */
    public function Selection($values)
    {
        $size = count($values);

        for ($i = 0; $i < $size-1; $i++)
        {
            $min = $i;

            for ($j = $i + 1; $j < $size; $j++)
            {
                if ($values[$j] < $values[$min])
                {
                    $min = $j;
                }
            }

            $temp = $values[$i];
            $values[$i] = $values[$min];
            $values[$min] = $temp;
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

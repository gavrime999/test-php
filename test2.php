<?php

$data1 = [
    'parent.child.field'      => 1,
    'parent.child.field2'     => 2,
    'parent2.child.name'      => 'test',
    'parent2.child2.name'     => 'test',
    'parent2.child2.position' => 10,
    'parent3.child3.position' => 10,
];

function toggleTree(array $input)
{
    $result = [];
    foreach ($input as $key => $value) {
        // Определяем по значению массива - будем ли мы разбивать ключ на ветки или значение обратно.
        if (is_array($value)) {
            // Рекурсивно склеиваем ветку
            $bondNodes = toggleTree($value);
            foreach ($bondNodes as $nodeKey => $nodeValue) {
                $result[$key . '.' . $nodeKey] = $nodeValue;
            }
        } else {
            // Бьем ключ на массив названий веток
            $nodesKeys = explode('.', $key);
            // Проверяем количество предполагаемых веток, если их нет - оставляем как есть
            if (count($nodesKeys) < 2) {
                $result[$key] = $value;
                continue;
            }
            // Получаем корневой ключ
            $rootKey = array_shift($nodesKeys);
            // Переворачиваем массив для array_reduce
            $nodesKeys = array_reverse($nodesKeys);
 
            // Создаем массив-ветку
            $node = [
                $rootKey => array_reduce(
                    $nodesKeys,
                    function ($carry, $item) {
                        return [$item => $carry];
                    },
                    $value
                ),
            ];
            // Рекурсивно мерджим с остальными ветками
            $result = array_merge_recursive($result, $node);
        }
    }
 
    return $result;
}
 
 
$data2 = toggleTree($data1);
echo '$data2 =';
echo "\n";
print_r($data2);

echo '$data1 =';
echo "\n"; 
$data1 = toggleTree($data2);
echo str_replace('Array','',print_r($data1,true));
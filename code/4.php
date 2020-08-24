<?php

$array = [];
foreach (['a', '42'] as $key) {
    $array[$key] = $key;
}

$merge = array_merge($array, []);
echo $merge[0] ?? 'null';

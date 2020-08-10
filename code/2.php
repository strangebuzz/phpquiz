<?php

function generator() {
    yield '1' => 4;
    yield '0' => 2;
}

$array = [... generator()];

echo implode('', $array);

<?php
declare(strict_types=1);

function foo(int &$int): void {
    $int = '5';
}

foo($x);
var_dump($x);

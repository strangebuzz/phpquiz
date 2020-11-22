<?php
declare(strict_types=1);

error_reporting(0);
ini_set('display_errors', '0');
set_exception_handler(function($e) {
    die(get_class($e));
});

function foo(int $x): void
{
    var_dump($x);
    exit;
}

foo(3 . 7 + 5);

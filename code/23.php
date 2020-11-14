<?php
declare(strict_types=1);

class Foo {
    public int $x = 0;
}

$o = new Foo();
try {
    $x = &$o->x;
    $x = '42';
    var_dump($o->x);
} catch (throwable $e) {
    echo get_class($e);
}

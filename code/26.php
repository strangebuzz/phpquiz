<?php
declare(strict_types=1);

class Foo {
    public int $x;
    public int $y;
}

function display(object $object): void {
    foreach ($object as $key => $value) {
        echo $key, ':', $value ?? 'null', ',';
    }
}

$o = new Foo;
display($o);
$o->x = 4;
$o->y = 2;
display($o);
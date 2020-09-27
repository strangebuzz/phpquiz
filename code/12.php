<?php
declare(strict_types=1);

class Foo {
    public function __set(string $name, int $value): void {
        $this->{$name} = $value;
    }

    public function __get(string $name): int {
        return $this->{$name};
    }
}

$o = new Foo;
$o->x = '3';
var_dump($o->x);

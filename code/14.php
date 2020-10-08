<?php

error_reporting(0);

class Foo {
    public function __toString(): string {
        return 'foo';
    }

    public function bar(): string {
        return 'bar';
    }
}

$o = new Foo();

echo "$o->bar() / {$o->bar()}";

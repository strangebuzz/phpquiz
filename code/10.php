<?php
declare(strict_types=1);

class Foo {
    public function __call(): void {
        $args = func_get_args();
        echo gettype($args[0]), ', ', gettype($args[1]);
    }
}

(new Foo)->bar('x');

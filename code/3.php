<?php
declare(strict_types=0);
class A {
    public function get(string $name, $default) {
        if (property_exists($this, $name)) {
            return $this->{$name};
        }

        return $default;
    }
}

class B extends A {
    private $foo = 42;
}

var_dump((new B)->get('foo', null));

<?php
declare(strict_types=1);

class A {
    public static function foo(): static {
        return new A;
    }
}

class B extends A {
    public static function foo(): static {
        return new B;
    }
}

var_dump(B::foo()::class);

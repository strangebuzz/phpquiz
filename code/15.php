<?php

class A {
    private string $foo = 'bar';

    public function show(callable $callable): void
    {
        echo $callable();
    }
}

(new A)->show(fn() => $this->foo);

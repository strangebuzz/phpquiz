<?php
declare(strict_types=1);

interface A {
    public function foo(int $id): void;
}

interface B {
    public function foo(string $id): void;
}

class Bar implements A, B {
    public function foo($id): void
    {
        echo gettype($id);
    }
}

(new Bar)->foo(true);
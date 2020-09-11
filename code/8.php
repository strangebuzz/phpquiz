<?php

trait T {
    abstract private function get(): int;

    public function show() {
        var_dump($this->get());
    }
}

class A {
    use T;

    private function get(): int {
        return 42;
    }
}

(new A)->show();

<?php
declare(strict_types=1);

namespace Foo;

class Bar {
    public function __call(string $name, array $args): void {
        echo $name;
    }
}

(new Bar)();

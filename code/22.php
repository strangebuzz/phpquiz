<?php
declare(strict_types=1);
class Foo {
    public function __set(string $name, int $value): void {
        $this->{$name} = $value;
    }
}

try {
    $o = new Foo;
    $o->{'"foo&voilà"'} = '5';
    echo implode(', ', array_keys(get_object_vars($o)));
} catch (throwable $e) {
    echo get_class($e);
}

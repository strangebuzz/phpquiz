<?php
declare(strict_types=1);

$generator = (function() {
    yield 42;
});

array_walk($generator, function (int $value) {
    var_dump($value);
});

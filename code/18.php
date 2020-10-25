<?php
declare(strict_types=0);
error_reporting(0);

function foo(int $int): void {
    echo "[{$int}]";
}
try {
    foo(1_0);
    foo('2_0');
} catch (TypeError) {
    echo 'TypeError';
}

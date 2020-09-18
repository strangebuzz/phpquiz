<?php declare(strict_types=1);

function numeric($value): void {
    if (is_numeric($value)) {
        echo 'numeric';
    } else {
        echo 'not numeric';
    }

    echo ': ', (int) $value;
}

numeric("\n\t\n 42");
echo ', ';
numeric("1337  ");

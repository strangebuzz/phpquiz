<?php

namespace App;

function foo() {
    echo 'foo';
}

echo foo::class;

(foo::class)();

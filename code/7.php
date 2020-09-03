<?php

namespace Foo;

class Bar {
    public function bar() {
        Bar();
    }
}

function bar() {
    echo 'BAR';
}

(new Bar())->bar();

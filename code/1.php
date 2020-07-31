<?php

namespace \Foo \Bar;

class A {
    static public function show() {
        echo static::class;
    }
}

class B extends A {}

B::show();

<?php

class Foo {
    function __destruct() {
        echo 'D';
    }
}

(function() {
    echo '1';
    new Foo;
    echo '2';
    $o = new Foo;
    echo '3';
})();
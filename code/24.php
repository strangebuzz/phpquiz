<?php
namespace FOO;
class FOO {
    public const FOO = null;
    public $X = null;
    public function BAR(): void {}
}

echo class_exists('foo\foo') ? 'x':'o';
echo method_exists(FOO::class, 'bar') ? 'x':'o';
echo property_exists(FOO::class, 'x') ? 'x':'o';
echo defined(FOO::class.'::foo')? 'x':'o';
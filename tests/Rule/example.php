<?php

class Foo
{
    public function bar()
    {
        $c = new Category();
        $a = new \DateTime();
        $b = new DateTimeZone('UTC');
        $v = new class {};
        throw new Exception('msg');
        throw new InvalidArgumentException('args');
    }
}

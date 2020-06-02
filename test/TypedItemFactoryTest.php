<?php

namespace App;

class TypedItemFactoryTest extends \PHPUnit\Framework\TestCase
{

    public function testSulfurasItemCreateWithFactory()
    {
        $factory = new TypedItemFactory();
        $factory->create();
    }
}

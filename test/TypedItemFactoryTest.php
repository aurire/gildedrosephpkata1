<?php

namespace App;

use App\TypedItem\BrieItem;
use App\TypedItem\PassesItem;
use App\TypedItem\SimpleItem;
use App\TypedItem\SulfurasItem;

/**
 * Class TypedItemFactoryTest
 * @package App
 */
class TypedItemFactoryTest extends \PHPUnit\Framework\TestCase
{
    public function testSulfurasItemCreateWithFactory()
    {
        $item = new Item('Sulfuras the legendary', 10, 10);

        $factory = new TypedItemFactory();
        $sulfurasTypedItem = $factory->create($item);

        $this->assertTrue($sulfurasTypedItem instanceof SulfurasItem);
    }

    public function testBrieItemCreateWithFactory()
    {
        $item = new Item('Aged Brie', 10, 10);

        $factory = new TypedItemFactory();
        $brie = $factory->create($item);

        $this->assertTrue($brie instanceof BrieItem);
    }

    public function testPassesItemCreateWithFactory()
    {
        $item = new Item('Backstage passes for something', 10, 10);

        $factory = new TypedItemFactory();
        $passItem = $factory->create($item);

        $this->assertTrue($passItem instanceof PassesItem);
    }

    public function testSimpleItemCreateWithFactory()
    {
        $item = new Item('Unknown name', 10, 10);

        $factory = new TypedItemFactory();
        $simpleItem = $factory->create($item);

        $this->assertTrue($simpleItem instanceof SimpleItem);
    }
}

<?php

namespace App\TypedItem;

use App\Item;

class SulfurasItemTest extends \PHPUnit\Framework\TestCase
{
    public function testConstructAndGetItem()
    {
        $item = new Item('not important', 15, 20);
        $simpleItem = new SimpleItem($item);

        $this->assertTrue($simpleItem->getItem() === $item);
    }

    public function testGetTypeName()
    {
        $item = new Item('not important', 15, 20);
        $simpleItem = new SimpleItem($item);

        $this->assertTrue($simpleItem->getTypeName() === SimpleItem::NAME);
    }

    public function testCorrectlyDetectsType()
    {
        //irrelevant - should not be created using detectType
    }

    public function testProcessesCorrectly()
    {
        $item = new Item('Sulfuras, Hand of Ragnaros', 15, 20);
        $typedItem = new SulfurasItem($item);
        $typedItem->process();

        //@TODO: write a test, before actualy writing logic for Sulfuras item
        $this->assertTrue(false);
    }
}

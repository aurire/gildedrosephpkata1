<?php

namespace App\TypedItem;

use App\Item;

/**
 * Class SulfurasItemTest
 * @package App\TypedItem
 */
class SimpleItemTest extends \PHPUnit\Framework\TestCase
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

    //public function testCorrectlyDetectsType()
    //{
    // //irrelevant - should not be created using detectType
    //}
}

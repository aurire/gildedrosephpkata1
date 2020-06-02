<?php

namespace App\TypedItem;

use App\Item;

/**
 * Class SulfurasItemTest
 * @package App\TypedItem
 */
class SulfurasItemTest extends \PHPUnit\Framework\TestCase
{
    public function testConstructAndGetItem()
    {
        $item = new Item('not important', 15, 20);
        $sulfurasItem = new SulfurasItem($item);

        $this->assertTrue($sulfurasItem->getItem() === $item);
    }

    public function testGetTypeName()
    {
        $item = new Item('not important', 15, 20);
        $sulfurasItem = new SulfurasItem($item);

        $this->assertTrue($sulfurasItem->getTypeName() === SulfurasItem::NAME);
    }

    public function testCorrectlyDetectsType()
    {
        $items = [
            'Sulfuras, Hand of Ragnaros',
            'Other type of sulfuras, also legendary',
        ];

        /** @var Item $item */
        foreach ($items as $item) {
            $this->assertTrue(SulfurasItem::isOfThisType($item));
        }
    }

    public function testCorrectlyDetectsThatItIsNotThatType()
    {
        $items = [
            'Backstage passes to a TAFKAL80ETC concert',
            'Conjured Mana Cake',
        ];

        /** @var Item $item */
        foreach ($items as $item) {
            $this->assertFalse(SulfurasItem::isOfThisType($item));
        }
    }
}

<?php

namespace App\TypedItem;

use App\Item;

/**
 * Class BrieItemTest
 * @package App\TypedItem
 */
class BrieItemTest extends \PHPUnit\Framework\TestCase
{
    public function testConstructAndGetItem()
    {
        $item = new Item('not important', 15, 20);
        $brieItem = new BrieItem($item);

        $this->assertTrue($brieItem->getItem() === $item);
    }

    public function testGetTypeName()
    {
        $item = new Item('not important', 15, 20);
        $sulfurasItem = new BrieItem($item);

        $this->assertTrue($sulfurasItem->getTypeName() === BrieItem::NAME);
    }

    public function testCorrectlyDetectsType()
    {
        $items = [
            'Aged Brie',
            'Dutch aged brie',
            'Aged Brie Super Extra',
        ];

        /** @var Item $item */
        foreach ($items as $item) {
            $this->assertTrue(BrieItem::isOfThisType($item));
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

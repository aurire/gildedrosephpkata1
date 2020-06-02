<?php

namespace App\TypedItem;

use App\Item;

class PassesItemTest extends \PHPUnit\Framework\TestCase
{
    public function testConstructAndGetItem()
    {
        $item = new Item('not important', 15, 20);
        $passesItem = new PassesItem($item);

        $this->assertTrue($passesItem->getItem() === $item);
    }

    public function testGetTypeName()
    {
        $item = new Item('not important', 15, 20);
        $passesItem = new PassesItem($item);

        $this->assertTrue($passesItem->getTypeName() === PassesItem::NAME);
    }

    public function testCorrectlyDetectsType()
    {
        $items = [
            'Backstage passes to a TAFKAL80ETC concert',
            'Backstage passes to a Guilded Roses concert',
        ];

        /** @var Item $item */
        foreach ($items as $item) {
            $this->assertTrue(BrieItem::isOfThisType($item));
        }
    }

    public function testCorrectlyDetectsThatItIsNotThatType()
    {
        $items = [
            'Backstreet passport DESTINY',
            'Conjured Mana Cake',
        ];

        /** @var Item $item */
        foreach ($items as $item) {
            $this->assertFalse(SulfurasItem::isOfThisType($item));
        }
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

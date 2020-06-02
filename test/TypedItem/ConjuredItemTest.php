<?php

namespace App\TypedItem;

use App\Item;

/**
 * Class ConjuredItemTest
 * @package App\TypedItem
 */
class ConjuredItemTest extends \PHPUnit\Framework\TestCase
{
    public function testConstructAndGetItem()
    {
        $item = new Item('not important', 15, 20);
        $conjuredItem = new ConjuredItem($item);

        $this->assertTrue($conjuredItem->getItem() === $item);
    }

    public function testGetTypeName()
    {
        $item = new Item('not important', 15, 20);
        $conjuredItem = new ConjuredItem($item);

        $this->assertTrue($conjuredItem->getTypeName() === ConjuredItem::NAME);
    }

    public function testCorrectlyDetectsType()
    {
        $items = [
            'Conjured Mana Cake',
            'Conjured apple',
            'Conjured peach',
        ];

        /** @var Item $item */
        foreach ($items as $item) {
            $this->assertTrue(ConjuredItem::isOfThisType($item));
        }
    }

    public function testCorrectlyDetectsThatItIsNotThatType()
    {
        $items = [
            'Injured soldier',
            'Concordia Mana Cake',
        ];

        /** @var Item $item */
        foreach ($items as $item) {
            $this->assertFalse(ConjuredItem::isOfThisType($item));
        }
    }
}

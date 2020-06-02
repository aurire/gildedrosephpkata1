<?php

namespace App;

class GildedRoseTest extends \PHPUnit\Framework\TestCase
{
    public function testFooStaysFooAfterUpdate()
    {
        $items = [new Item("foo", 0, 0)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertEquals("foo", $items[0]->name);
    }

    /**
     * $sell_in decreases by one unless it is less or equal to zero.
     * $quality decreases according rules set by types
     * $quality never goes below zero
     * $quality never goes above 50 unless it can be above 50.
     */

    /**
     * @param GildedRose $gildedRose
     * @param array $lastDay
     */
    private function compareSellInWithLastDay(GildedRose $gildedRose, array $lastDay)
    {
        reset ($lastDay);
        /** @var Item $item */
        foreach ($gildedRose->getItems() as $item) {
            $lastDayItem = current($lastDay);
            if ($lastDayItem > 0) {
                $this->assertEquals(
                    $item->sell_in,
                    $lastDayItem - 1
                );

            }
            next($lastDay);
        }
    }

    /**
     * @dataProvider itemsProvider
     *
     * @param array $items
     * @param int $dayCount
     */
    public function testSellInDecreasesByOne(array $items, int $dayCount)
    {
        $gildedRose = new GildedRose($items);

        if ($dayCount < 1) {
            return;
        }

        $lastDay = [];
        for ($day = 0; $day < $dayCount; $day++) {
            if ($day > 0) {
                $this->compareSellInWithLastDay($gildedRose, $lastDay);
            }

            //save state for comparison
            $lastDay = [];
            /** @var Item $item */
            foreach ($gildedRose->getItems() as $item) {
                $lastDay[] = $item->sell_in;
            }
            $gildedRose->updateQuality();
        }
        $this->compareSellInWithLastDay($gildedRose, $lastDay);
    }

    /**
     * @return array
     */
    public function itemsProvider()
    {
        return [
            [
                [
                    new Item('+5 Dexterity Vest', 10, 20),
                    new Item('Aged Brie', 2, 0),
                    new Item('Elixir of the Mongoose', 5, 7),
                    new Item('Sulfuras, Hand of Ragnaros', 0, 80),
                    new Item('Sulfuras, Hand of Ragnaros', -1, 80),
                    new Item('Backstage passes to a TAFKAL80ETC concert', 15, 20),
                    new Item('Backstage passes to a TAFKAL80ETC concert', 10, 49),
                    new Item('Backstage passes to a TAFKAL80ETC concert', 5, 49),
                    // this conjured item does not work properly yet
                    new Item('Conjured Mana Cake', 3, 6)
                ],
                100
            ]
        ];
    }

    public function testQualityDoesNotGetLowerThanZero()
    {

    }
}

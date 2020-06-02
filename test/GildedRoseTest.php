<?php

namespace App;

/**
 * Class GildedRoseTest
 * @package App
 */
class GildedRoseTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test that:
     *
     * $sell_in decreases by one unless it is less or equal to zero.
     * $quality decreases according rules set by types
     * $quality never goes below zero
     * $quality never goes above 50 unless it can be above 50.
     */

    /**
     * @param GildedRose $gildedRose
     * @param array $lastDay
     * @param Closure $comparison
     */
    private function compareWithLastDay(GildedRose $gildedRose, array $lastDay, Callable $comparison)
    {
        reset($lastDay);
        /** @var Item $item */
        foreach ($gildedRose->getItems() as $item) {
            $lastDayItem = current($lastDay);
            $comparison($lastDayItem, $item);

            next($lastDay);
        }
    }

    public function compareAllDaysWithPrevious(GildedRose $gildedRose, int $dayCount, Callable $comparison)
    {
        if ($dayCount < 1) {
            return;
        }

        $lastDay = [];
        for ($day = 0; $day < $dayCount; $day++) {
            if ($day > 0) {
                $this->compareWithLastDay($gildedRose, $lastDay, $comparison);
            }

            //save state for comparison
            $lastDay = [];
            /** @var Item $item */
            foreach ($gildedRose->getItems() as $item) {
                $lastDay[] = clone $item;
            }
            $gildedRose->updateQuality();
        }
        $this->compareWithLastDay($gildedRose, $lastDay, $comparison);
    }

    /**
     * @param Item $lastDay
     * @param Item $currentDay
     */
    public function compareSellIn(Item $lastDay, Item $currentDay)
    {
        if ($lastDay->sell_in > 0) {
            $this->assertEquals(
                $currentDay->sell_in,
                $lastDay->sell_in - 1
            );
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
        $this->compareAllDaysWithPrevious($gildedRose, $dayCount, [$this, 'compareSellIn']);
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

    /**
     * @dataProvider itemsProvider
     *
     * @param array $items
     * @param int $dayCount
     */
    public function testXXX(array $items, int $dayCount)
    {
        $gildedRose = new GildedRose($items);
        $this->compareAllDaysWithPrevious(
            $gildedRose,
            $dayCount,
            function (Item $lastDay, Item $currentDay) {
                if ($lastDay->sell_in > 0) {
                    $this->assertEquals(
                        $currentDay->sell_in,
                        $lastDay->sell_in - 1
                    );
                }
            }
        );
    }

    /**
     * @dataProvider itemsProvider
     *
     * @param array $items
     * @param int $dayCount
     */
    public function testQualityDoesNotGetLowerThanZero(array $items, int $dayCount)
    {
        $gildedRose = new GildedRose($items);
        for ($day = 0; $day < $dayCount; $day++) {
            $gildedRoseItems = $gildedRose->getItems();
            /** @var Item $item */
            foreach ($gildedRoseItems as $item) {
                $this->assertTrue(
                    $item->quality >= 0
                );
            }
            $gildedRose->updateQuality();
        }
    }

    /**
     * @param Item $item
     * @return bool
     */
    private function canQualityBeOverZero(Item $item): bool
    {
        return strpos(strtolower($item->name), 'sulfuras') !== false;
    }

    /**
     * @dataProvider itemsProvider
     *
     * @param array $items
     * @param int $dayCount
     */
    public function testQualityDoesNotGetOverFiftyUnlessItCan(array $items, int $dayCount)
    {
        $gildedRose = new GildedRose($items);
        for ($day = 0; $day < $dayCount; $day++) {
            $gildedRoseItems = $gildedRose->getItems();
            /** @var Item $item */
            foreach ($gildedRoseItems as $item) {
                if (!$this->canQualityBeOverZero($item)) {
                    $this->assertTrue(
                        $item->quality <= 50
                    );
                }
            }
            $gildedRose->updateQuality();
        }
    }

    /**
     * @param string $name
     * @return string
     */
    public function detectItemTypeByName(string $name): string
    {
        $mapKeywordToType = [
            'sulfuras' => 'sulfuras',
            'backstage passes' => 'passes',
            'aged brie' => 'brie',
            'conjured' => 'conjured',
        ];
        foreach ($mapKeywordToType as $keyword => $type) {
            if (strpos(strtolower($name), $keyword) !== false) {
                return $type;
            }
        }

        return 'simple';
    }

    /**
     * @dataProvider itemsProvider
     *
     * @param array $items
     * @param int $dayCount
     */
    public function testQualityGoesDownAccordingRules(array $items, int $dayCount)
    {
        //$quality decreases according rules set by types
        $gildedRose = new GildedRose($items);
        $this->compareAllDaysWithPrevious(
            $gildedRose,
            $dayCount,
            function (Item $lastDay, Item $currentDay) {
                $type = $this->detectItemTypeByName($currentDay->name);
                switch ($type) {
                    case 'sulfuras':
                        $this->assertEquals(
                            $currentDay->quality,
                            $lastDay->quality
                        );

                        break;
                    case 'passes':
                        /**
                         * like aged brie, increases in Quality as its SellIn value approaches;
                         * Quality increases by 2 when there are 10 days or less
                         * and by 3 when there are 5 days or less
                         * but Quality drops to 0 after the concert
                         */
                        if ($lastDay->quality < 50 && $lastDay->quality > 0) {
                            if ($lastDay->sell_in > 10) {
                                $qualityBoost = 1;
                            } elseif ($lastDay->sell_in > 5) {
                                $qualityBoost = 2;
                            } elseif ($lastDay->sell_in > 0) {
                                $qualityBoost = 3;
                            } else {
                                $qualityBoost = 0;
                            }
                            $boosted = $lastDay->quality + $qualityBoost;
                            $this->assertEquals(
                                $currentDay->quality,
                                $boosted > 50 ? 50 : $boosted
                            );
                        }

                        break;
                    case 'brie':
                        if ($lastDay->quality < 50) {
                            $qualityBoost = $lastDay->sell_in > 0 ? 1 : 2;
                            $boosted = $lastDay->quality + $qualityBoost;
                            $this->assertEquals(
                                $currentDay->quality,
                                $boosted > 50 ? 50 : $boosted
                            );
                        }

                        break;
                    case 'conjured':
                        break;
                    case 'simple':
                    default:
                        if ($lastDay->quality > 0) {
                            $qualityPenalty = $lastDay->sell_in > 0 ? 1 : 2;
                            $qualityWithPenalty = $lastDay->quality - $qualityPenalty;
                            $this->assertEquals(
                                $currentDay->quality,
                                $qualityWithPenalty < 0 ? 0 : $qualityWithPenalty
                            );
                        }

                        break;
                }
            }
        );
    }
}

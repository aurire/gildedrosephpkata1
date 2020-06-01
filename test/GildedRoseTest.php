<?php

namespace App;

class GildedRoseTest extends \PHPUnit\Framework\TestCase {
    public function testFooStaysFooAfterUpdate() {
        $items      = [new Item("foo", 0, 0)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertEquals("foo", $items[0]->name);
    }
}

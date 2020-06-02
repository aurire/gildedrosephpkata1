<?php

namespace App\TypedItem;

use App\Item;
use App\TypedItem;

/**
 * Class BrieItem
 * @package App\TypedItem
 */
class BrieItem extends TypedItem
{
    const NAME = 'brie';
    const KEYWORD = 'aged brie';

    /**
     * @param Item $item
     * @return int
     */
    private function getIncreaseSize(Item $item)
    {
        return $item->sell_in < 0 ? 2 : 1;
    }

    /**
     * @param Item $item
     */
    public function increaseQuality(Item $item)
    {
        $item->quality += $this->getIncreaseSize($item);
        $item->quality = $item->quality > 50 ? 50 : $item->quality;
    }

    /**
     *
     */
    public function process()
    {
        /** @var Item $item */
        $item = $this->getItem();
        $item->sell_in--;
        $this->increaseQuality($item);
    }
}

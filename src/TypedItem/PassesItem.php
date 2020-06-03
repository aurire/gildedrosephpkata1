<?php

namespace App\TypedItem;

use App\Item;
use App\TypedItem;

/**
 * Class PassesItem
 * @package App\TypedItem
 */
class PassesItem extends TypedItem
{
    const NAME = 'passes';
    const KEYWORD = 'backstage passes';

    /**
     * @param Item $item
     * @return int
     */
    private function getIncreaseSize(Item $item)
    {
        if ($item->sell_in > 10) {
            $size = 1;
        } elseif ($item->sell_in > 5) {
            $size = 2;
        } elseif ($item->sell_in > 0) {
            $size = 3;
        } else {
            $size = 0;
        }

        return $size;
    }

    /**
     * @param Item $item
     */
    public function increaseQuality(Item $item)
    {
        $item->quality += $this->getIncreaseSize($item);
        $item->quality = $item->quality > static::QUALITY_MAX ? static::QUALITY_MAX : $item->quality;
    }

    /**
     *
     */
    public function process()
    {
        /** @var Item $item */
        $item = $this->getItem();
        $this->increaseQuality($item);
        $item->sell_in--;
    }
}

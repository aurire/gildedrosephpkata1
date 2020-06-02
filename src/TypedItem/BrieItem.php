<?php

namespace App\TypedItem;

use App\Item;
use App\TypedItem;

class BrieItem extends TypedItem
{
    const NAME = 'brie';
    const KEYWORD = 'aged brie';

    private function getIncreaseSize(Item $item)
    {
        return $item->sell_in > 0 ? 1 : 2;
    }

    public function increaseQuality(Item $item)
    {
        $item->quality += $this->getIncreaseSize($item);
        $item->quality = $item->quality > 50 ? 50 : $item->quality;
    }

    public function process()
    {
        /** @var Item $item */
        $item = $this->getItem();
        if ($item->sell_in > 0) {
            $item->sell_in--;
        }
        $this->increaseQuality($item);
    }
}

<?php

namespace App\TypedItem;

use App\Item;
use App\TypedItem;

class PassesItem extends TypedItem
{
    const NAME = 'passes';
    const KEYWORD = 'backstage passes';

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

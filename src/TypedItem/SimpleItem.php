<?php

namespace App\TypedItem;

use App\Item;
use App\TypedItem;

class SimpleItem extends TypedItem
{
    const NAME = 'simple';

    private function getDecreaseSize(Item $item)
    {
        if ($item->sell_in > 0) {
            $size = 1;
        } else {
            $size = 2;
        }

        return $size;
    }

    public function decreaseQuality(Item $item)
    {
        if ($item->quality > 0) {
            $item->quality -= $this->getDecreaseSize($item);
            $item->quality = $item->quality < 0 ? 0 : $item->quality;
        }
    }

    public function process()
    {
        /** @var Item $item */
        $item = $this->getItem();
        if ($item->sell_in > 0) {
            $item->sell_in--;
        }
        $this->decreaseQuality($item);
    }
}

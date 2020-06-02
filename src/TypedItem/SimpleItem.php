<?php

namespace App\TypedItem;

use App\Item;
use App\TypedItem;

/**
 * Class SimpleItem
 * @package App\TypedItem
 */
class SimpleItem extends TypedItem
{
    const NAME = 'simple';

    /**
     * @param Item $item
     * @return int
     */
    private function getDecreaseSize(Item $item)
    {
        if ($item->sell_in < 0) {
            $size = 2;
        } else {
            $size = 1;
        }

        return $size;
    }

    /**
     * @param Item $item
     */
    public function decreaseQuality(Item $item)
    {
        if ($item->quality > 0) {
            $item->quality -= $this->getDecreaseSize($item);
            $item->quality = $item->quality < 0 ? 0 : $item->quality;
        }
    }

    /**
     *
     */
    public function process()
    {
        /** @var Item $item */
        $item = $this->getItem();
        $item->sell_in--;
        $this->decreaseQuality($item);
    }
}

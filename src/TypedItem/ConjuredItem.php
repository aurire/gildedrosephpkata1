<?php

namespace App\TypedItem;

use App\Item;
use App\TypedItem;

/**
 * Class ConjuredItem
 * @package App\TypedItem
 */
class ConjuredItem extends TypedItem
{
    const NAME = 'conjured';
    const KEYWORD = 'conjured';


    /**
     * @param Item $item
     * @return int
     */
    private function getDecreaseSize(Item $item)
    {
        if ($item->sell_in < 0) {
            $size = 4;
        } else {
            $size = 2;
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

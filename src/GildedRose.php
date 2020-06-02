<?php
/**
 * Main class for GildedRose application
 */

namespace App;

/**
 * Class GildedRose
 * @package App
 */
final class GildedRose
{
    /**
     * @var array
     */
    private $items = [];

    /**
     * @var TypedItemFactory
     */
    public TypedItemFactory $typedItemsFactory;

    /**
     * GildedRose constructor.
     * @param $items
     */
    public function __construct($items)
    {
        $this->items = $items;
        $typedItemsFactory = new TypedItemFactory();
        $this->typedItemsFactory = $typedItemsFactory;
    }

    /**
     *
     */
    public function updateQuality()
    {
        /** @var Item $item */
        foreach ($this->items as $item) {
            $typedItem = $this->typedItemsFactory->create($item);
            $typedItem->process();
        }
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }
}

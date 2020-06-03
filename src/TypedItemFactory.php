<?php

namespace App;

use App\TypedItem\BrieItem;
use App\TypedItem\ConjuredItem;
use App\TypedItem\PassesItem;
use App\TypedItem\SimpleItem;
use App\TypedItem\SulfurasItem;

/**
 * Class TypedItemFactory
 * @package App
 */
class TypedItemFactory
{
    /**
     * May as well scan the directory, but this is simpler and allows manual priority organization without
     * additional burden of specifying them in TypedItem classes and then sorting them.
     */
    private $availableTypes = [
        SulfurasItem::NAME,
        BrieItem::NAME,
        PassesItem::NAME,
        ConjuredItem::NAME,
    ];

    /**
     * @param $name
     * @return string
     */
    private function getTypeByName($name)
    {
        foreach ($this->availableTypes as $availableType) {
            /** @var TypedItem $class */
            $class = 'App\\TypedItem\\' . ucfirst($availableType) . 'Item';
            if ($class::isOfThisType($name)) {
                return $class::NAME;
            }
        }

        return 'simple';
    }

    /**
     * @param Item $item
     * @return TypedItem
     */
    public function create(Item $item): TypedItem
    {
        $typeName = $this->getTypeByName($item->name);
        $class = 'App\\TypedItem\\' . ucfirst($typeName) . 'Item';
        if (class_exists($class)) {
            return new $class($item);
        }

        return new SimpleItem($item);
    }
}

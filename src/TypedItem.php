<?php

namespace App;

/**
 * Class TypedItem
 * @package App
 */
abstract class TypedItem
{
    const NAME = 'undefined';
    const KEYWORD = 'undefined';

    /**
     * @var Item
     */
    private ?Item $item = null;

    /**
     * SulfurasItem constructor.
     * @param Item $item
     */
    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    /**
     * @return Item
     */
    public function getItem(): Item
    {
        return $this->item;
    }

    /**
     * @return string
     */
    public function getTypeName(): string
    {
        return static::NAME;
    }

    /**
     * @param string $name
     * @return bool
     */
    public static function isOfThisType(string $name): bool
    {
        return strpos(strtolower($name), static::KEYWORD) !== false;
    }

    /**
     * @return void
     */
    abstract public function process();
}

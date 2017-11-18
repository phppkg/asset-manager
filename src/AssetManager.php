<?php
/**
 * Created by PhpStorm.
 * User: Inhere
 * Date: 2017/11/18 0018
 * Time: 19:11
 */

namespace Inhere\Asset;

/**
 * Class AssetManager
 * @package Inhere\Asset
 */
class AssetManager
{
    private $bags = [];

    public function newBag(string $name): AssetBag
    {
        return new AssetBag();
    }

    /**
     * @return array
     */
    public function getBags(): array
    {
        return $this->bags;
    }

    /**
     * @param array $bags
     */
    public function setBags(array $bags)
    {
        $this->bags = $bags;
    }
}

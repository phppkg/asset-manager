<?php
/**
 * Created by PhpStorm.
 * User: Inhere
 * Date: 2017/11/18 0018
 * Time: 19:11
 */

namespace Inhere\Asset;

use Inhere\Asset\Interfaces\AssetBagInterface;

/**
 * Class AssetManager
 * @package Inhere\Asset
 */
class AssetManager
{
    /**
     * @var array
     */
    private $options;

    /**
     * @var AssetBag[]
     */
    private $bags = [];

    /**
     * AssetManager constructor.
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    /**
     * @param string $name
     * @return AssetBag
     */
    public function bag(string $name): AssetBag
    {
        return $this->newBag($name);
    }

    /**
     * @param string $name
     * @return AssetBag
     */
    public function newBag(string $name): AssetBag
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        if (!$bag = $this->getBag($name)) {
            $bag = new AssetBag();

            $this->bags[$name] = $bag;
        }

        return $bag;
    }

    /**
     * the default css bag.
     * @return AssetBag
     */
    public function getCss()
    {
        return $this->bag('css');
    }

    /**
     * the default js bag.
     * @return AssetBag
     */
    public function getJs()
    {
        return $this->bag('js');
    }

    /**
     * @param string $name
     * @param bool $thrError
     * @return AssetBag|null
     * @throws \RuntimeException
     */
    public function getBag(string $name, $thrError = false)
    {
        return $this->get($name, $thrError);
    }

    /**
     * @param string $name
     * @param bool $thrError
     * @return AssetBag|null
     * @throws \RuntimeException
     */
    public function get(string $name, $thrError = false)
    {
        $bag = $this->bags[$name] ?? null;

        if ($thrError && !$bag) {
            throw new \RuntimeException("The bag '{$name}' does not exist in the manager");
        }

        return $bag;
    }

    /**
     * @param string $name
     * @param AssetBagInterface $bag
     * @return $this
     */
    public function setBag(string $name, AssetBagInterface $bag)
    {
        $this->bags[$name] = $bag;

        return $this;
    }

    /**
     * @param string $name
     * @param AssetBagInterface $bag
     * @return $this
     */
    public function set(string $name, AssetBagInterface $bag)
    {
        $this->bags[$name] = $bag;

        return $this;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has(string $name)
    {
        return isset($this->bags[$name]);
    }

    /**
     * @return AssetBag[]
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

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param array $options
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Inhere
 * Date: 2017/11/18 0018
 * Time: 19:11
 */

namespace Inhere\Asset;

use Inhere\Asset\Interfaces\AssetBagInterface;
use Inhere\Asset\Interfaces\AssetItemInterface;
use Inhere\Asset\Interfaces\ManagerInterface;
use Inhere\Asset\Items\Css;
use Inhere\Asset\Items\CssCode;
use Inhere\Asset\Items\FileItem;
use Inhere\Asset\Items\Js;
use Inhere\Asset\Items\JsCode;

/**
 * Class AssetManager
 * @package Inhere\Asset
 */
class AssetManager implements ManagerInterface
{
    const TYPE_CSS = 'css';
    const TYPE_JS = 'js';

    /**
     * @var array
     */
    private $options;

    /**
     * @var AssetBag[]
     */
    private $bags = [];

    /** @var array */
    private $uri2names = [
        // '/css/app.css' => 'css',
    ];

    /**
     * AssetManager constructor.
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    /**
     * @param string $path
     * @param bool $local
     * @param bool $filter
     * @param null|array $attributes
     * @return $this
     */
    public function addCss(string $path, $local = true, $filter = true, array $attributes = null)
    {
        return $this->addItemByType(AssetItem::CSS, new Css($path, $local, $filter, $attributes));
    }

    /**
     * @param string $content
     * @param bool $filter
     * @param null|array $attributes
     * @return $this
     */
    public function addCssCode(string $content, $filter = true, $attributes = null)
    {
        return $this->addItemByType(AssetItem::CSS_CODE, new CssCode($content, $filter, $attributes));
    }

    /**
     * @param string $path
     * @param bool $local
     * @param bool $filter
     * @param null|array $attributes
     * @return $this
     */
    public function addJs(string $path, $local = true, $filter = true, array $attributes = null)
    {
        return $this->addItemByType(AssetItem::JS, new Js($path, $local, $filter, $attributes));
    }

    /**
     * @param string $content
     * @param bool $filter
     * @param null|array $attributes
     * @return $this
     */
    public function addJsCode(string $content, $filter = true, array $attributes = null)
    {
        return $this->addItemByType(AssetItem::JS_CODE, new JsCode($content, $filter, $attributes));
    }

    /**
     * @param string $type
     * @param AssetItemInterface $item
     * @return $this
     */
    public function addItemByType(string $type, AssetItemInterface $item)
    {
        $bag = $this->newBag($type);

        $bag->add($item);

        return $this;
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
            $bag = new AssetBag($name);

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
     * ```php
     * $items = $bag->getItems();
     * ```
     * @param AssetBag $bag
     * @param string $type
     * @return \Generator
     */
    public function collectItemsByType(AssetBag $bag, string $type)
    {
        /** @var AssetItem $item */
        foreach ($bag->getItems() as $item) {
            if ($item->getType() === $type) {
                yield $item;
            }
        }
    }

    public function outputJs($bagName = null)
    {

    }

    /**
     * @param AssetBag $bag
     * @param string $type
     * @param callable $callback The path callback handler
     */
    public function output(AssetBag $bag, string $type, callable $callback)
    {
        /** @var FileItem $file */
        foreach ($bag as $file) {
            $file->getPath();
        }

        /** @var FileItem $file */
        foreach ($this->collectItemsByType($bag, $type) as $file) {
            $file->getPath();
        }

        $callback($this);
    }

    public function getLinks(AssetBag $bag, $wrapperTag = true)
    {

    }

    public function getScripts(AssetBag $bag, $wrapperTag = true)
    {

    }

    /**
     * @param string $name
     * @return string
     */
    public function findName($name)
    {
        if (isset($this->uri2names[$name])) {
            $name = $this->uri2names[$name];
        }

        return $name;
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

    /**
     * @return array
     */
    public function getUri2names(): array
    {
        return $this->uri2names;
    }

    /**
     * @param array $uri2names
     */
    public function setUri2names(array $uri2names)
    {
        $this->uri2names = $uri2names;
    }
}

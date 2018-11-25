<?php
/**
 * Created by PhpStorm.
 * User: Inhere
 * Date: 2017/11/18 0018
 * Time: 19:11
 */

namespace PhpComp\Asset;

use PhpComp\Asset\Item\CssFile;
use PhpComp\Asset\Item\CssCode;
use PhpComp\Asset\Item\FileItem;
use PhpComp\Asset\Item\JsCode;
use PhpComp\Asset\Item\JsFile;

/**
 * Class AssetManager
 * @package PhpComp\Asset
 */
class AssetManager implements ManagerInterface
{
    public const TYPE_CSS = 'css';
    public const TYPE_JS = 'js';

    /** @var array */
    private $options;

    /** @var AssetBag[] */
    private $bags = [];

    /** @var array */
    private $uri2names = [
        // '/css/app.css' => 'css',
    ];

    /**
     * @param array $options
     * @return AssetManager
     */
    public static function create(array $options = []): self
    {
        return new self($options);
    }

    /**
     * AssetManager constructor.
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    /**
     * add css file to the default css asset bag
     * @param string $path css file path.
     * @param bool $local local file ?
     * @param bool $filter
     * @param array $attributes
     * @return $this
     */
    public function addCss(string $path, bool $local = true, $filter = true, array $attributes = []): self
    {
        return $this->addItemToBag(new CssFile($path, $local, $filter, $attributes), AssetBag::CSS_BAG);
    }

    /**
     * add css code to the default css asset bag
     * @param string $content
     * @param bool $filter
     * @param array $attributes
     * @return $this
     */
    public function addCssCode(string $content, $filter = true, $attributes = null): self
    {
        return $this->addItemToBag(new CssCode($content, $filter, $attributes), AssetBag::CSS_BAG);
    }

    /**
     * add js file to the default js asset bag
     * @param string $path
     * @param bool $local
     * @param bool $filter
     * @param array $attributes
     * @return $this
     */
    public function addJs(string $path, bool $local = true, $filter = true, array $attributes = []): self
    {
        return $this->addItemToBag(new JsFile($path, $local, $filter, $attributes), AssetBag::JS_BAG);
    }

    /**
     * add js code to the default js asset bag
     * @param string $content
     * @param bool $filter
     * @param array $attributes
     * @return $this
     */
    public function addJsCode(string $content, $filter = true, array $attributes = []): self
    {
        return $this->addItemToBag(new JsCode($content, $filter, $attributes), AssetBag::JS_BAG);
    }

    /**
     * @param AssetItemInterface $item
     * @param string $name
     * @return $this
     */
    public function addItemToBag(AssetItemInterface $item, string $name): self
    {
        $this->newBag($name)->add($item);
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
     * @param string $name bag name
     * @return AssetBag
     */
    public function newBag(string $name): AssetBag
    {
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
    public function getCss(): AssetBag
    {
        return $this->bag(self::CSS_BAG);
    }

    /**
     * the default js bag.
     * @return AssetBag
     */
    public function getJs(): AssetBag
    {
        return $this->bag(self::JS_BAG);
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
    public function setBag(string $name, AssetBagInterface $bag): self
    {
        $this->bags[$name] = $bag;
        return $this;
    }

    /**
     * @param string $name
     * @param AssetBagInterface $bag
     * @return $this
     */
    public function set(string $name, AssetBagInterface $bag): self
    {
        $this->bags[$name] = $bag;
        return $this;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool
    {
        return isset($this->bags[$name]);
    }

    /**
     * ```php
     * $items = $bag->getItems();
     * ```
     * @param AssetBag $bag
     * @param string|array $type
     * @return \Generator
     */
    public function collectItemsByType(AssetBag $bag, $type)
    {
        $types = (array)$type;

        /** @var AssetItem $item */
        foreach ($bag->getItems() as $item) {
            if (\in_array($item->getType(), $types, true)) {
                yield $item;
            }
        }
    }

    /**
     * @param null|string $bagName
     * @param $callback
     * @throws \RuntimeException
     */
    public function outputCss(string $bagName = null, $callback = null)
    {
        /** @var AssetBag $bag */
        $bag = $bagName ? $this->getBag($bagName, true) : $this->getJs();

        return $this->output($bag, [AssetItem::CSS_CODE, AssetItem::CSS_FILE], $callback);
    }

    /**
     * @param null|string $bagName
     * @param $callback
     * @throws \RuntimeException
     */
    public function outputJs(string $bagName = null, $callback = null)
    {
        /** @var AssetBag $bag */
        $bag = $bagName ? $this->getBag($bagName, true) : $this->getJs();

        return $this->output($bag, [AssetItem::JS_CODE, AssetItem::JS_FILE], $callback);
    }

    /**
     * @param AssetBag $bag
     * @param string|array $type
     * @param callable $callback The path callback handler
     */
    public function output(AssetBag $bag, $type, callable $callback)
    {
        /** @var FileItem $file */
        foreach ($this->collectItemsByType($bag, $type) as $file) {
            $file->getPath();
        }

        if ($callback) {
            $callback($this);
        }
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
    public function findName(string $name): string
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

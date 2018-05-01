<?php
/**
 * Created by PhpStorm.
 * User: Inhere
 * Date: 2017/11/18 0018
 * Time: 19:09
 */

namespace Inhere\Asset;

use Inhere\Asset\Item\CssFile;
use Inhere\Asset\Item\CssCode;
use Inhere\Asset\Item\JsFile;
use Inhere\Asset\Item\JsCode;

/**
 * Class AssetBag
 * @package Inhere\Asset
 * @ref Phalcon\Assets
 */
class AssetBag implements AssetBagInterface, \Countable, \Iterator
{
    /**
     * asset bag name
     * @var string
     */
    protected $name;

    /**
     * asset bag version
     * @var string
     */
    protected $version;

    /**
     * the prefix Path
     * @var string
     */
    protected $prefix;

    /**
     * the target Path - The name of the final output to disk.
     * @var string
     */
    protected $targetPath;

    /**
     * the target uri - The script tag is generated with this URI
     * @var string
     */
    protected $targetUri;

    /** @var bool */
    protected $targetLocal = false;

    /**
     * the source uri
     * @var string
     */
    protected $sourcePath;

    /**
     * Join all the resources in a single file
     * @var bool
     */
    protected $merged = false;

    /**
     * The item keys list
     * @var array
     */
    private $keys;

    /** @var array */
    protected $items = [];

    /** @var array */
    protected $codes = [];

    /** @var array */
    protected $filters = [];

    /** @var bool */
    private $atLocal;

    /** @var array */
    private $attributes = [];

    /** @var int */
    private $index;

    /**
     * AssetBag constructor.
     * @param string|null $name
     */
    public function __construct(string $name = null)
    {
        if ($name) {
            $this->setName($name);
        }

        $this->keys = [];
    }

    /**
     * add a css file asset
     * @param string $path
     * @param null|bool $atLocal
     * @param bool $filter
     * @param array|null $attributes
     * @return $this
     */
    public function addCss(string $path, $atLocal = null, $filter = true, array $attributes = null): self
    {
        $atLocal = $atLocal ?? $this->atLocal;
        $attributes = $attributes ?: $this->attributes;

        return $this->add(new CssFile($path, $atLocal, $filter, $attributes));
    }

    /**
     * add a css code asset
     * @param string $content
     * @param bool $filter
     * @param array|null $attributes
     * @return $this
     */
    public function addCssCode(string $content, $filter = true, array $attributes = null): self
    {
        $attributes = $attributes ?: $this->attributes;

        return $this->add(new CssCode($content, $filter, $attributes));
    }

    /**
     * add a js file asset
     * @param string $path
     * @param null|bool $atLocal
     * @param bool $filter
     * @param array|null $attributes
     * @return $this
     */
    public function addJs(string $path, $atLocal = true, $filter = true, array $attributes = null): self
    {
        $atLocal = $atLocal ?? $this->atLocal;
        $attributes = $attributes ?: $this->attributes;

        return $this->add(new JsFile($path, $atLocal, $filter, $attributes));
    }

    /**
     * add a js code asset
     * @param string $content
     * @param bool $filter
     * @param array|null $attributes
     * @return $this
     */
    public function addJsCode(string $content, $filter = true, array $attributes = null): self
    {
        $attributes = $attributes ?: $this->attributes;

        return $this->add(new JsCode($content, $filter, $attributes));
    }

    /**
     * @param AssetItemInterface $item
     * @return $this
     */
    public function add(AssetItemInterface $item): self
    {
        if (!$this->has($item)) {
            if ($item instanceof AssetItemInterface) {
                $this->items[] = $item;
            } else {
                $this->codes[] = $item;
            }

            // save item key
            $this->keys[$item->getKey()] = true;
        }

        return $this;
    }

    /**
     * @param AssetItemInterface $item
     * @return $this
     */
    public function addItem(AssetItemInterface $item): self
    {
        return $this->add($item);
    }

    /**
     * ```php
     * $items = $bag->getFilteredItems();
     * ```
     * @param string|array $type
     * @return \Generator
     */
    public function getFilteredItems($type)
    {
        $types = (array)$type;

        /** @var AssetItem $item */
        foreach ($this->getItems() as $item) {
            if (\in_array($item->getType(), $types, true)) {
                yield $item;
            }
        }
    }

    /**
     * @param AssetItemInterface $item
     * @return bool
     */
    public function has(AssetItemInterface $item): bool
    {
        return isset($this->keys[$item->getKey()]);
    }

    /**
     * @param bool $merge
     * @return $this
     */
    public function merge($merge = true): self
    {
        $this->merged = (bool)$merge;

        return $this;
    }

    /**
     * @param FilterInterface $filter
     * @return $this
     */
    public function addFilter(FilterInterface $filter): self
    {
        $this->filters[] = $filter;

        return $this;
    }

    /**
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return $this->items[$this->index];
    }

    /**
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        $this->index++;
    }

    /**
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->index;
    }

    /**
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid(): bool
    {
        return isset($this->items[$this->index]);
    }

    /**
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->index = 0;
    }

    /**
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count(): int
    {
        return \count($this->items);
    }

    /**
     * @param string $name
     * @return AssetBag
     */
    public function setName(string $name): AssetBag
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getTargetPath(): string
    {
        return $this->targetPath;
    }

    /**
     * @param string $targetPath
     * @return AssetBag
     */
    public function setTargetPath(string $targetPath): AssetBag
    {
        $this->targetPath = $targetPath;

        return $this;
    }

    /**
     * @return string
     */
    public function getTargetUri(): string
    {
        return $this->targetUri;
    }

    /**
     * @param string $targetUri
     * @return AssetBag
     */
    public function setTargetUri(string $targetUri): AssetBag
    {
        $this->targetUri = $targetUri;

        return $this;
    }

    /**
     * @return bool
     */
    public function isMerged(): bool
    {
        return $this->merged;
    }


    /**
     * @return int
     */
    public function getIndex(): int
    {
        return $this->index;
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    /**
     * @param array $filters
     * @return $this
     */
    public function setFilters(array $filters): self
    {
        $this->filters = $filters;

        return $this;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param array $items
     * @return $this
     */
    public function setItems(array $items): self
    {
        foreach ($items as $item) {
            $this->addItem($item);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->prefix;
    }

    /**
     * @param string $prefix
     *
     * ```php
     * if (APP_ENV === 'dev') {
     *      $footerBag->setPrefix('/');
     * } else {
     *      $footerBag->setPrefix('http:://cdn.example.com/');
     * }
     * ```
     */
    public function setPrefix(string $prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @param string $version
     */
    public function setVersion(string $version)
    {
        $this->version = $version;
    }
}

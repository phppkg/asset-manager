<?php
/**
 * Created by PhpStorm.
 * User: Inhere
 * Date: 2017/11/18 0018
 * Time: 19:09
 */

namespace Inhere\Asset;

use Inhere\Asset\Interfaces\AssetBagInterface;
use Inhere\Asset\Interfaces\AssetItemInterface;
use Inhere\Asset\Interfaces\FilterInterface;
use Inhere\Asset\Items\Css;
use Inhere\Asset\Items\CssCode;
use Inhere\Asset\Items\Js;
use Inhere\Asset\Items\JsCode;

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
     * the target Path
     * @var string
     */
    protected $targetPath;

    /**
     * the target uri
     * @var string
     */
    protected $targetUri;

    /**
     * @var bool
     */
    protected $targetLocal = false;

    /**
     * the source uri
     * @var string
     */
    protected $sourcePath;

    /**
     * @var bool
     */
    protected $merged = false;

    /**
     * The item keys list
     * @var array
     */
    private $keys;

    /**
     * @var array
     */
    protected $items = [];

    /**
     * @var array
     */
    protected $codes = [];

    /**
     * @var array
     */
    protected $filters = [];

    /** @var bool */
    private $atLocal;

    /**
     * @var array
     */
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
     * @param string $path
     * @param null|bool $atLocal
     * @param bool $filter
     * @param array|null $attributes
     * @return $this
     */
    public function addCss(string $path, $atLocal = null, $filter = true, array $attributes = null)
    {
        $atLocal = $atLocal ?? $this->atLocal;
        $attributes = $attributes ?: $this->attributes;

        return $this->add(new Css($path, $atLocal, $filter, $attributes));
    }

    /**
     * @param string $content
     * @param bool $filter
     * @param array|null $attributes
     * @return $this
     */
    public function addCssCode(string $content, $filter = true, array $attributes = null)
    {
        $attributes = $attributes ?: $this->attributes;

        return $this->add(new CssCode($content, $filter, $attributes));
    }

    /**
     * @param string $path
     * @param null|bool $atLocal
     * @param bool $filter
     * @param array|null $attributes
     * @return $this
     */
    public function addJs(string $path, $atLocal = true, $filter = true, array $attributes = null)
    {
        $atLocal = $atLocal ?? $this->atLocal;
        $attributes = $attributes ?: $this->attributes;

        return $this->add(new Js($path, $atLocal, $filter, $attributes));
    }

    /**
     * @param string $content
     * @param bool $filter
     * @param array|null $attributes
     * @return $this
     */
    public function addJsCode(string $content, $filter = true, array $attributes = null)
    {
        $attributes = $attributes ?: $this->attributes;

        return $this->add(new JsCode($content, $filter, $attributes));
    }

    /**
     * @param AssetItemInterface $item
     * @return $this
     */
    public function add(AssetItemInterface $item)
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
    public function addItem(AssetItemInterface $item)
    {
        return $this->add($item);
    }

    /**
     * @param AssetItemInterface $item
     * @return bool
     */
    public function has(AssetItemInterface $item)
    {
        return isset($this->keys[$item->getKey()]);
    }

    /**
     * @param bool $merge
     * @return $this
     */
    public function merge($merge = true)
    {
        $this->merged = (bool)$merge;

        return $this;
    }

    /**
     * @param FilterInterface $filter
     * @return $this
     */
    public function addFilter(FilterInterface $filter)
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
    public function valid()
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
    public function count()
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
    public function getTargetPath()
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
    public function getTargetUri()
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
    public function setFilters(array $filters)
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
    public function setItems(array $items)
    {
        foreach ($items as $item) {
            $this->addItem($item);
        }

        return $this;
    }
}

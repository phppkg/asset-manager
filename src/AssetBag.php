<?php
/**
 * Created by PhpStorm.
 * User: Inhere
 * Date: 2017/11/18 0018
 * Time: 19:09
 */

namespace Inhere\Asset;

use Inhere\Asset\Interfaces\AssetBagInterface;
use Inhere\Asset\Items\Css;

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

    /**
     * @var array
     */
    protected $attributes = [];

    /** @var int */
    private $index;

    /** @var array */
    private $itemKeys;

    /**
     * AssetBag constructor.
     * @param string|null $name
     */
    public function __construct(string $name = null)
    {
        if ($name) {
            $this->setName($name);
        }
    }

    public function addCss(string $path, $atLocal = true, $filter = true, $attributes = null)
    {
        return $this->add(new Css($path, $atLocal, $filter, $attributes));
    }

    public function addCssCode(string $content, $atLocal = true, $filter = true, $attributes = null)
    {
        return $this->addItem(AssetItem::CSS, $path, $atLocal, $filter, $attributes);
    }

    public function add(AssetItem $item)
    {
        return $this->addItem($item);
    }

    public function addItem(AssetItem $item)
    {
        if (!$this->has($item)) {
            if ($item instanceof AssetItem) {
                $this->items[] = $item;
            } else {
                $this->codes[] = $item;
            }
        }

        return $this;
    }

    /**
     * @param AssetItem $item
     * @return bool
     */
    public function has(AssetItem $item)
    {
        return \in_array($item->getKey(), $this->itemKeys, true);
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
}

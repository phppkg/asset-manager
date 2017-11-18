<?php
/**
 * Created by PhpStorm.
 * User: Inhere
 * Date: 2017/11/18 0018
 * Time: 19:29
 */

namespace Inhere\Asset;

use Inhere\Asset\Interfaces\AssetItemInterface;

/**
 * Class AssetItem
 * @package Inhere\Asset
 */
class AssetItem implements AssetItemInterface
{
    const CSS = 'css';
    const CSS_CODE = 'cssCode';

    const JS = 'js';
    const JS_CODE = 'jsCode';

    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $path;

    /**
     * @var bool
     */
    private $local;

    /**
     * @var bool
     */
    private $filter;

    /**
     * @var null|array
     */
    private $attributes;

    /**
     * Resource constructor.
     * @param string $type
     * @param string $path
     * @param bool $local
     * @param bool $filter
     * @param null|array $attributes
     */
    public function __construct(string $type, string $path, $local = true, $filter = true, $attributes = null)
    {
        $this->type = $type;
        $this->path = $path;
        $this->local = (bool)$local;
        $this->filter = (bool)$filter;
        $this->attributes = $attributes;

        $this->getKey();
    }

    /**
     * Get the resource's key.
     * @return string
     */
    public function getKey()
	{
	    if (!$this->key) {
            $key = $this->getType() . ':' . $this->getPath();
            $this->key = substr(md5($key), 0, 10);
        }

		return $this->key;
	}

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return $this
     */
    public function setPath(string $path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return bool
     */
    public function isLocal(): bool
    {
        return $this->local;
    }

    /**
     * @param bool $local
     * @return $this
     */
    public function setLocal($local)
    {
        $this->local = (bool)$local;

        return $this;
    }

    /**
     * @return bool
     */
    public function isFilter(): bool
    {
        return $this->filter;
    }

    /**
     * @param bool $filter
     * @return $this
     */
    public function setFilter(bool $filter)
    {
        $this->filter = $filter;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param array|null $attributes
     * @return $this
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }
}

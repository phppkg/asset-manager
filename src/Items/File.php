<?php
/**
 * Created by PhpStorm.
 * User: Inhere
 * Date: 2017/11/19 0019
 * Time: 17:57
 */

namespace Inhere\Asset\Items;

use Inhere\Asset\AssetItem;

/**
 * Class File
 * @package Inhere\Asset\Items
 */
class File extends AssetItem
{
    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $path;

    /**
     * @var bool
     */
    private $local;

    /**
     * constructor.
     * @param string $type
     * @param string $path
     * @param bool $local
     * @param bool $filter
     * @param null|array $attributes
     */
    public function __construct(string $type, string $path, $local = true, $filter = true, $attributes = null)
    {
        $this->path = $path;
        $this->local = (bool)$local;

        parent::__construct($type, $filter, $attributes);

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
}

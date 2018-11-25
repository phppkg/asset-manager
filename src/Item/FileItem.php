<?php
/**
 * Created by PhpStorm.
 * User: Inhere
 * Date: 2017/11/19 0019
 * Time: 17:57
 */

namespace PhpComp\Asset\Item;

use PhpComp\Asset\Util\AssetHelper;
use PhpComp\Asset\AssetItem;

/**
 * Class FileItem
 * @package PhpComp\Asset\Item
 */
class FileItem extends AssetItem
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
     * @param array $attributes
     */
    public function __construct(string $type, string $path, bool $local = true, $filter = true, array $attributes = [])
    {
        $this->local = $local;
        $this->setPath($path);

        parent::__construct($type, $filter, $attributes);

        $this->getKey();
    }

    /**
     * Get the resource's key.
     * @return string
     */
    public function getKey(): string
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
    public function setPath(string $path): self
    {
        $this->path = \trim($path);

        // check is remote asset path.
        if (AssetHelper::isRemotePath($this->path)) {
            $this->local = false;
        }

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
    public function setLocal($local): self
    {
        $this->local = (bool)$local;

        return $this;
    }
}

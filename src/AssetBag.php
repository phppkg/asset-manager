<?php
/**
 * Created by PhpStorm.
 * User: Inhere
 * Date: 2017/11/18 0018
 * Time: 19:09
 */

namespace Inhere\Asset;

use Inhere\Asset\Interfaces\AssetBagInterface;

/**
 * Class AssetBag
 * @package Inhere\Asset
 * @ref Phalcon\Assets
 */
class AssetBag implements AssetBagInterface
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
    protected $merged = false;

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
}

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
abstract class AssetItem implements AssetItemInterface
{
    const CSS = 'css';
    const CSS_CODE = 'cssCode';

    const JS = 'js';
    const JS_CODE = 'jsCode';

    /**
     * @var string
     */
    private $type;

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
     * @param bool $filter
     * @param null|array $attributes
     */
    public function __construct(string $type, $filter = true, $attributes = null)
    {
        $this->type = $type;
        $this->filter = (bool)$filter;
        $this->attributes = $attributes;
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

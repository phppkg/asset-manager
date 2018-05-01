<?php
/**
 * Created by PhpStorm.
 * User: Inhere
 * Date: 2017/11/18 0018
 * Time: 19:29
 */

namespace Inhere\Asset;

/**
 * Class AssetItem
 * @package Inhere\Asset
 */
abstract class AssetItem implements AssetItemInterface
{
    const CSS_CODE = 'cssCode';
    const CSS_FILE = 'cssFile';

    const JS_CODE = 'jsCode';
    const JS_FILE = 'jsFile';

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
    public function __construct(string $type, $filter = true, array $attributes = null)
    {
        $this->type = $type;
        $this->filter = (bool)$filter;
        $this->attributes = $attributes;
    }

    /**
     * @param bool $wrapperTag
     * @return string
     */
    public function toString($wrapperTag = true): string
    {
        return '';
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * @param bool $toString
     * @return array|string
     */
    public function buildAttributes($toString = true)
    {
        $attrs = [];

        foreach ($this->getAttributes() as $k => $val) {
            $attrs[] = $k . '="' . $val . '"';
        }

        if ($toString) {
            return $attrs ? \implode(' ', $attrs) : '';
        }

        return $attrs;
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
    public function setType(string $type): self
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
    public function setFilter($filter): self
    {
        $this->filter = (bool)$filter;

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
     * @param array $attributes
     * @return $this
     */
    public function setAttributes(array $attributes): self
    {
        $this->attributes = $attributes;

        return $this;
    }
}

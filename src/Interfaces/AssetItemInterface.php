<?php
/**
 * Created by PhpStorm.
 * User: Inhere
 * Date: 2017/11/18 0018
 * Time: 21:13
 */

namespace Inhere\Asset\Interfaces;

/**
 * Interface AssetItemInterface
 * @package Inhere\Asset\Interfaces
 */
interface AssetItemInterface
{
    /**
     * Get the resource's key.
     * @return string
     */
    public function getKey();

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @param string $type
     * @return $this
     */
    public function setType(string $type);

    /**
     * @return bool
     */
    public function isFilter(): bool;

    /**
     * @param bool $filter
     * @return $this
     */
    public function setFilter($filter);

    /**
     * @return array|null
     */
    public function getAttributes();

    /**
     * @param array $attributes
     * @return $this
     */
    public function setAttributes(array $attributes);
}

<?php
/**
 * Created by PhpStorm.
 * User: Inhere
 * Date: 2017/11/18 0018
 * Time: 21:13
 */

namespace PhpComp\Asset;

/**
 * Interface AssetItemInterface
 * @package PhpComp\Asset
 */
interface AssetItemInterface
{
    /**
     * Get the resource's key.
     * @return string
     */
    public function getKey(): string ;

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @param string $type
     * @return $this|mixed
     */
    public function setType(string $type);

    /**
     * @return bool
     */
    public function isFilter(): bool;

    /**
     * @param bool $filter
     * @return $this|mixed
     */
    public function setFilter($filter);

    /**
     * @return array|null
     */
    public function getAttributes();

    /**
     * @param array $attributes
     * @return $this|mixed
     */
    public function setAttributes(array $attributes);
}

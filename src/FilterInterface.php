<?php
/**
 * Created by PhpStorm.
 * User: Inhere
 * Date: 2017/11/18 0018
 * Time: 19:38
 */

namespace PhpComp\Asset;

/**
 * Interface FilterInterface
 * @package PhpComp\Asset
 */
interface FilterInterface
{
    /**
     * @param string $content
     * @return string
     */
    public function filter(string $content): string;
}

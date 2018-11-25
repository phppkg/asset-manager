<?php
/**
 * Created by PhpStorm.
 * User: Inhere
 * Date: 2017/11/18 0018
 * Time: 19:37
 */

namespace PhpComp\Asset\Filter;

use PhpComp\Asset\FilterInterface;

/**
 * Class NullFilter
 * @package PhpComp\Asset\Filter
 */
class NullFilter implements FilterInterface
{
    /**
     * @param string $content
     * @return string
     */
    public function filter(string $content): string
    {
        return $content;
    }
}

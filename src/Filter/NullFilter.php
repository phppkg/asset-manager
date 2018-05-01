<?php
/**
 * Created by PhpStorm.
 * User: Inhere
 * Date: 2017/11/18 0018
 * Time: 19:37
 */

namespace Inhere\Asset\Filter;

use Inhere\Asset\FilterInterface;

/**
 * Class NullFilter
 * @package Inhere\Asset\Filter
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

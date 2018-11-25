<?php
/**
 * Created by PhpStorm.
 * User: Inhere
 * Date: 2017/11/18 0018
 * Time: 19:41
 */

namespace PhpComp\Asset\Filter;

use PhpComp\Asset\FilterInterface;

/**
 * Class CssMinify
 * @package PhpComp\Asset\Filter
 */
class CssMinify implements FilterInterface
{
    // private $minifier;

    public function __construct()
    {
        // $this->minifier = new Minify\CSS();
    }

    /**
     * @param string $content
     * @return string
     */
    public function filter(string $content): string
    {
        return $content;
    }
}

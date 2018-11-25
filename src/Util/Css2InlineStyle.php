<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 2017-12-14
 * Time: 9:46
 */

namespace PhpComp\Asset\Util;

/**
 * Class Css2InlineStyle
 * @package PhpComp\Asset\Util
 *
 * ```php
 * $cis = new Css2InlineStyle;
 *
 * $html = file_get_contents(__DIR__ . '/examples/sumo/index.htm');
 * $css = file_get_contents(__DIR__ . '/examples/sumo/style.css');
 *
 * $cis->addCss($css)->inject($html);
 * ```
 */
class Css2InlineStyle
{
    /** @var bool Merge multi css to one style tag. */
    public $merge = false;

    /** @var bool Will clear up blanks. */
    public $minimize = true;
}

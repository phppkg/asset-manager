<?php
/**
 * Created by PhpStorm.
 * User: Inhere
 * Date: 2017/11/18 0018
 * Time: 19:27
 */

namespace Inhere\Asset\Items;

/**
 * Class CssCode
 * @package Inhere\Asset\Items
 */
final class CssCode extends Code
{
    /**
     * @inheritdoc
     */
    public function __construct($content, $filter = true, $attributes = null)
    {
        if (!$attributes) {
            $attributes['type'] = 'text/css';
        }

        parent::__construct(self::CSS_CODE, $content, $filter, $attributes);
    }
}

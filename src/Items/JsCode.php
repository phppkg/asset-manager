<?php
/**
 * Created by PhpStorm.
 * User: Inhere
 * Date: 2017/11/18 0018
 * Time: 19:27
 */

namespace Inhere\Asset\Items;

use Inhere\Asset\AssetItem;

/**
 * Class JsCode
 * @package Inhere\Asset\Items
 */
final class JsCode extends AssetItem
{
    /**
     * @inheritdoc
     */
    public function __construct($type, $path, $local = true, $filter = true, $attributes = null)
    {
        parent::__construct(self::JS_CODE, $path, $local, $filter, $attributes);
    }
}

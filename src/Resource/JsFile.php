<?php
/**
 * Created by PhpStorm.
 * User: Inhere
 * Date: 2017/11/18 0018
 * Time: 19:27
 */

namespace Inhere\Asset\Resource;

use Inhere\Asset\AssetItem;

/**
 * Class JsFile
 * @package Inhere\Asset\Resource
 */
final class JsFile extends AssetItem
{
    /**
     * @inheritdoc
     */
    public function __construct($type, $path, $local = true, $filter = true, $attributes = null)
    {
        parent::__construct(self::JS, $path, $local, $filter, $attributes);
    }
}

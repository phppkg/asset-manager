<?php
/**
 * Created by PhpStorm.
 * User: Inhere
 * Date: 2017/11/18 0018
 * Time: 19:27
 */

namespace Inhere\Asset\Items;

/**
 * Class JsFile
 * @package Inhere\Asset\Items
 */
final class Js extends File
{
    /**
     * @inheritdoc
     */
    public function __construct($type, $path, $local = true, $filter = true, $attributes = null)
    {
        parent::__construct(self::JS, $path, $local, $filter, $attributes);
    }
}

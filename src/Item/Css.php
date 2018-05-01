<?php
/**
 * Created by PhpStorm.
 * User: Inhere
 * Date: 2017/11/18 0018
 * Time: 19:27
 */

namespace Inhere\Asset\Item;

/**
 * Class CssFile
 * @package Inhere\Asset\Item
 */
final class Css extends FileItem
{
    /**
     * @inheritdoc
     */
    public function __construct(string $path, $local = true, $filter = true, $attributes = null)
    {
        parent::__construct(self::CSS, $path, $local, $filter, $attributes);
    }

    /**
     * @param bool $wrapperTag
     * @return string
     */
    public function toString($wrapperTag = true): string
    {
        $path = $this->getPath();

        if ($wrapperTag) {
            return sprintf(
                '<link href="%s" rel="stylesheet" %s>',
                $path,
                $this->buildAttributes()
            );
        }

        return $path;
    }
}

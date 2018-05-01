<?php
/**
 * Created by PhpStorm.
 * User: Inhere
 * Date: 2017/11/18 0018
 * Time: 19:27
 */

namespace Inhere\Asset\Item;

/**
 * Class CssCode
 * @package Inhere\Asset\Item
 */
final class CssCode extends CodeItem
{
    /**
     * @inheritdoc
     */
    public function __construct($content, $filter = true, array $attributes = null)
    {
        if (!$attributes) {
            $attributes['type'] = 'text/css';
        }

        parent::__construct(self::CSS_CODE, $content, $filter, $attributes);
    }

    /**
     * @param bool $wrapperTag
     * @return string
     */
    public function toString($wrapperTag = true): string
    {
        $content = $this->getContent();

        if ($wrapperTag) {
            return sprintf('<style %s>%s</style>', $this->buildAttributes(), $content);
        }

        return $content;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Inhere
 * Date: 2017/11/18 0018
 * Time: 19:27
 */

namespace Inhere\Asset\Items;

/**
 * Class JsCode
 * @package Inhere\Asset\Items
 */
final class JsCode extends CodeItem
{
    /**
     * @inheritdoc
     */
    public function __construct($type, $content, $filter = true, $attributes = null)
    {
        if (!$attributes) {
            $attributes['type'] = 'text/javascript';
        }

        parent::__construct(self::JS_CODE, $content, $filter, $attributes);
    }

    /**
     * @param bool $wrapperTag
     * @return string
     */
    public function toString($wrapperTag = true)
    {
        $content = $this->getContent();

        if ($wrapperTag) {
            return sprintf('<script %s>%s</script>', $this->buildAttributes(), $content);
        }

        return $content;
    }
}


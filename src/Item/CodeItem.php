<?php
/**
 * Created by PhpStorm.
 * User: Inhere
 * Date: 2017/11/19 0019
 * Time: 18:02
 */

namespace Inhere\Asset\Item;

use Inhere\Asset\AssetItem;

/**
 * Class CodeItem
 * @package Inhere\Asset\Item
 */
class CodeItem extends AssetItem
{
    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $content;

    /**
     * constructor.
     * @param string $type
     * @param string $content
     * @param bool $filter
     * @param null|array $attributes
     */
    public function __construct(string $type, string $content, $filter = true, array $attributes = null)
    {
        $this->content = $content;

        parent::__construct($type, $filter, $attributes);

        $this->getKey();
    }

    /**
     * Get the resource's key.
     * @return string
     */
    public function getKey(): string
    {
        if (!$this->key) {
            $key = $this->getType() . ':' . $this->getContent();
            $this->key = substr(md5($key), 0, 10);
        }

        return $this->key;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content)
    {
        $this->content = $content;
    }
}

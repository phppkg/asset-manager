<?php
/**
 * Created by PhpStorm.
 * User: Inhere
 * Date: 2017/11/18 0018
 * Time: 19:38
 */

namespace Inhere\Asset\Interfaces;

/**
 * Interface FilterInterface
 * @package Inhere\Asset\Interfaces
 */
interface FilterInterface
{
    /**
     * @param string $content
     * @return string
     */
    public function filter(string $content): string;
}

<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 16/8/27
 * Time: 上午12:33
 */

namespace Inhere\Asset;

/**
 * Class AssetHelper
 * @package Inhere\Asset
 */
class AssetHelper
{
    /**
     * @var array
     */
    public static $patterns = [
        'cssJs' => '/.\.(css|js)$/i',
        'css' => '/.\.css$/i',
        'js' => '/.\.js$/i',
        'min' => '/.[-.]min\.(css|js)$/i',

        'font' => '/.\.(ttf|svg|eot|woff|woff2)$/i',
        'img' => '/.\.(png|jpg|jpeg|gif|ico)$/i',
    ];

    /**
     * Minify & gzip the data & (optionally) saves it to a file.
     *
     * @param string $content
     * @param string $saveTo Path to write the data to
     * @param int $level Compression level, from 0 to 9
     * @return string The minified & gzipped data
     */
    public static function gzip(string $content, string $saveTo = null, int $level = 9): string
    {
        // $content = $this->execute($path);
        $content = \gzencode($content, $level);

        // save to path
        if ($saveTo !== null) {
            \file_put_contents($saveTo, $content);
        }

        return $content;
    }

    /**
     * @param $file
     * @return bool
     */
    public static function isCss($file): bool
    {
        return 1 === \preg_match(static::$patterns['css'], trim($file));
    }

    /**
     * @param $file
     * @return bool
     */
    public static function isJs($file): bool
    {
        return 1 === \preg_match(static::$patterns['js'], trim($file));
    }

    /**
     * @param $file
     * @return bool
     */
    public static function isCssOrJs($file): bool
    {
        return 1 === \preg_match(static::$patterns['cssJs'], trim($file));
    }

    /**
     * @param $file
     * @return bool
     */
    public static function isMinCssOrJs($file): bool
    {
        return 1 === \preg_match(static::$patterns['min'], trim($file));
    }

    /**
     * @param $file
     * @return bool
     */
    public static function isFont($file): bool
    {
        return 1 === \preg_match(static::$patterns['font'], trim($file));
    }

    /**
     * @param $file
     * @return bool
     */
    public static function isImage($file): bool
    {
        return 1 === \preg_match(static::$patterns['img'], trim($file));
    }

}

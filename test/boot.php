<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 2017/5/28
 * Time: 下午10:36
 */

error_reporting(E_ALL | E_STRICT);
date_default_timezone_set('Asia/Shanghai');

spl_autoload_register(function($class)
{
    $file = null;

    if (0 === strpos($class,'PhpComp\Asset\Test\\')) {
        $path = str_replace('\\', '/', substr($class, strlen('PhpComp\Asset\Test\\')));
        $file = dirname(__DIR__) . "/tests/{$path}.php";
    } elseif (0 === strpos($class,'PhpComp\Asset\\')) {
        $path = str_replace('\\', '/', substr($class, strlen('PhpComp\Asset\\')));
        $file = dirname(__DIR__) . "/src/{$path}.php";
    }

    if ($file && is_file($file)) {
        include $file;
    }
});

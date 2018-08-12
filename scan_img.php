<?php
/**
 * Created by PhpStorm.
 * User: fangyong
 * Date: 2018/8/12
 * Time: 11:56
 */
require __DIR__ . '/Application/Autoload/Loader.php';

use Application\{
    Autoload\Loader,
    Web\Deep
};

Loader::init(__DIR__);

define('DEFAULT_URL', 'www.baidu.com');
define('DEFAULT_TAG', 'img');

$deep = new Deep();

$url = strip_tags($_GET['url']) ?? DEFAULT_URL;

$res = [];
foreach ($deep->scanImg($url) as $src)
{
    if($src && (stripos($src, 'png') || stripos($src, 'jpg')) && !in_array($src, $res))
    {
        $res[] = $src;
        printf('<br><img src="%s"', $src);
    }
}
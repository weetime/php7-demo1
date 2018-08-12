<?php
/**
 * Created by PhpStorm.
 * User: fangyong
 * Date: 2018/8/11
 * Time: 17:05
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
$tag = strip_tags($_GET['tag']) ?? DEFAULT_TAG;

$res = [];
foreach ($deep->scan($url, $tag) as $item)
{
    $src = $item['attributes']['src'] ?? NULL;
    if($src && (stripos($src, 'png') || stripos($src, 'jpg')) && !in_array($src, $res))
    {
        $res[] = $src;
        printf('<br><img src="%s"', $src);
    }
}
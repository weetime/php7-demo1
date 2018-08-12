<?php
/**
 * Created by PhpStorm.
 * User: fangyong
 * Date: 2018/8/7
 * Time: 14:28
 */
require __DIR__ . '/Application/Autoload/Loader.php';

use Application\{
    Autoload\Loader,
    Web\Hoover
};

Loader::init(__DIR__);



define('DEFAULT_URL', 'http://www.baidu.com');
define('DEFAULT_TAG', 'a');

$vac = new Hoover();

$url = strip_tags($_GET['url']) ?? DEFAULT_URL;
$tag = strip_tags($_GET['tag']) ?? DEFAULT_TAG;


echo 'Dump of Tags:' .PHP_EOL;
var_dump($vac->getTags($url, $tag));
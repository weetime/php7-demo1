<?php
require __DIR__ . '/Application/Autoload/Loader.php';

use Application\{
    Autoload\Loader,
    Test\TestClass
};

Loader::init(__DIR__);
$tester = new TestClass();
echo $tester->getTest();
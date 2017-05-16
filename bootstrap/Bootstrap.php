<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 16.05.17
 * Time: 11:46
 */

namespace app\bootstrap;


use app\dispatchers\DummyEventDispatcher;
use app\dispatchers\EventDispatcher;
use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $container = \Yii::$container;
        $container->setSingleton(EventDispatcher::class, DummyEventDispatcher::class);
    }
}
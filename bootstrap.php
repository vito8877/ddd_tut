<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');

require(__DIR__ . '/vendor/autoload.php');
require(__DIR__ . '/vendor/yiisoft/yii2/Yii.php');



//Yii::setAlias('@app', dirname(__DIR__) . '/entities');
//Yii::setAlias('@entities', dirname(__DIR__) . '/tests');

$config = \yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/config/web.php'),
    require(__DIR__ . '/config/test.php')
);

(new yii\web\Application($config));
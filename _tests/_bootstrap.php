<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');



Yii::setAlias('@tests', dirname(__DIR__) . '/tests');
Yii::setAlias('@entities', dirname(__DIR__) . '/tests');

$config = \yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../config/web.php'),
    require(__DIR__ . '/config/config.php')
);

(new yii\web\Application($config));


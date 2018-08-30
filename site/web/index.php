<?php
// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../../common/vendor/autoload.php';
require __DIR__ . '/../../common/vendor/yiisoft/yii2/Yii.php';

$config = array_merge_recursive(
    require(__DIR__ . '/../../common/config/config.php'),
    require(__DIR__ . '/../config/main.php')
);

(new yii\web\Application($config))->run();

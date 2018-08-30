<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@api', dirname(dirname(__DIR__)) . '/api');

$config = [
    'language' => 'ru-RU',
    'sourceLanguage' => 'en-US',

    'components' => [

        'account' => 'common\components\AccountComponent',
        
        'user' => [
            'identityClass' => 'common\models\UserIdentity',
        ],

        'cache' => [
            //'class' => 'yii\caching\FileCache',
            'class' => \yii\caching\DummyCache::class,
        ],

        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=lilu',
            'username' => 'root',
            'password' => 'pass',
            'charset' => 'utf8',
            'tablePrefix' => 'lu_',
            'enableSchemaCache' => true,
        ],

        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ]
];

return $config;

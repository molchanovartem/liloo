<?php
return [
    'id' => 'lilooApi',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',


    'components' => [
        'request' => [
            'enableCookieValidation' => false
        ],

        'response' => [
            'formatters' => [
                'json' => [
                    'class' => 'yii\web\JsonResponseFormatter',
                    'prettyPrint' => YII_DEBUG,
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                ],
            ],
        ],

        'user' => [
            'enableAutoLogin' => false,
            'enableSession' => false
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => false,
            'rules' => []
        ],
    ]
];
<?php
return [
    'id' => 'lilooSite',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'site\controllers',

    'components' => [
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'jsOptions' => ['position' => \yii\web\View::POS_HEAD],
                ],
            ],
        ],
        'request' => [
            'cookieValidationKey' => 'asdfjasdlkjasdfj',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => false,
            'rules' => [
            ]
        ],
    ]
];
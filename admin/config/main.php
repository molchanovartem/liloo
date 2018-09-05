<?php
return [
    'id' => 'lilooAdmin',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'admin\controllers',

    'components' => [
        'notice' => [
            'class' => 'admin\components\NoticeComponent',
        ],
        'request' => [
            'cookieValidationKey' => 'asdfjasdlczxcxzkjasdfj',
        ],
        'view' => [
            'class' => 'admin\core\web\View',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => false,
            'rules' => [
            ]
        ],
    ]
];
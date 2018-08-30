<?php
return [
    'id' => 'lilooAdmin',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'admin\controllers',

    'components' => [
        'request' => [
            'cookieValidationKey' => 'asdfjasdlczxcxzkjasdfj',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => false,
            'rules' => [
            ]
        ],
    ]
];
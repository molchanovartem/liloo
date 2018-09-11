<?php
return [
    'id' => 'lilooAdmin',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'admin\controllers',

    'components' => [
        'request' => [
            'cookieValidationKey' => 'asdfjasdlczxcxzkjasdfj',
        ],
        'view' => [
            'class' => 'common\core\web\View',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => false,
            'rules' => [
            ]
        ],
    ]
];
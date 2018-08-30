<?php
return [
    'id' => 'lilooApi',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',

    'modules' => [
        //'v1' => require(__DIR__ . '/../modules/v1/config/main.php')
    ],

    'components' => [
        /*
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'application/xml' => 'yii\web\XmlParser',
            ],
        ],
        */

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
            //'showScriptName' => false,
            'rules' => [
                /*
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/user',
                    'tokens' => [
                        '{id}' => '<id:\\d[\\d,]*>',
                        '{userId}' => '<userId:\\d[\\d,]*>',
                        '{specializationId}' => '<specializationId:\\d[\\d,]*>',
                        '{convenienceId}' => '<convenienceId:\\d[\\d,]*>',
                    ],
                    'extraPatterns' => [
                        'GET {userId}/profile' => 'view-profile',
                        'PUT,PATCH {userId}/profile' => 'update-profile',

                        'POST {userId}/specializations' => 'add-specialization',
                        'PUT,PATCH {userId}/specializations' => 'update-specialization',
                        'DELETE {userId}/specializations' => 'delete-specialization',
                        'DELETE {userId}/specializations/{specializationId}' => 'delete-specialization',

                        'POST {userId}/conveniences' => 'add-convenience',
                        'PUT,PATCH {userId}/conveniences' => 'update-convenience',
                        'DELETE {userId}/conveniences' => 'delete-convenience',
                        'DELETE {userId}/conveniences/{convenienceId}' => 'delete-convenience'
                    ],
                ],
                ['class' => 'yii\rest\UrlRule', 'controller' => ['v1/client', 'v1/service', 'v1/specialization', 'v1/convenience']],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/salon',
                    'tokens' => [
                        '{id}' => '<id:\\d[\\d,]*>',
                        '{salonId}' => '<salonId:\\d[\\d,]*>',
                        '{userId}' => '<userId:\\d[\\d,]*>',
                        '{serviceId}' => '<serviceId:\\d[\\d,]*>',
                        '{specializationId}' => '<specializationId:\\d[\\d,]*>',
                        '{convenienceId}' => '<convenienceId:\\d[\\d,]*>',
                    ],
                    'extraPatterns' => [
                        'GET {salonId}/users' => 'index-user',
                        'POST {salonId}/users' => 'add-user',
                        'PUT,PATCH {salonId}/users' => 'update-user',
                        'DELETE {salonId}/users' => 'delete-user',
                        'DELETE {salonId}/users/{userId}' => 'delete-user',

                        'GET {salonId}/users/{userId}/services' => 'index-user-service',
                        'POST {salonId}/users/{userId}/services' => 'add-user-service',
                        'PUT,PATCH {salonId}/users/{userId}/services' => 'update-user-service',
                        'DELETE {salonId}/users/{userId}/services' => 'delete-user-service',
                        'DELETE {salonId}/users/{userId}/services/{serviceId}' => 'delete-user-service',

                        'GET {salonId}/specializations' => 'index-specialization',
                        'POST {salonId}/specializations' => 'add-specialization',
                        'PUT,PATCH {salonId}/specializations' => 'update-specialization',
                        'DELETE {salonId}/specializations' => 'delete-specialization',
                        'DELETE {salonId}/specializations/{specializationId}' => 'delete-specialization',

                        'GET {salonId}/conveniences' => 'index-convenience',
                        'POST {salonId}/conveniences' => 'add-convenience',
                        'PUT,PATCH {salonId}/conveniences' => 'update-convenience',
                        'DELETE {salonId}/conveniences' => 'delete-convenience',
                        'DELETE {salonId}/conveniences/{convenienceId}' => 'delete-convenience',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/portfolio',
                    'tokens' => [
                        '{id}' => '<id:\\d[\\d,]*>',
                        '{salonId}' => '<salonId:\\d[\\d,]*>',
                        '{userId}' => '<userId:\\d[\\d,]*>',
                        '{serviceId}' => '<serviceId:\\d[\\d,]*>',
                    ],
                    'extraPatterns' => [
                        'GET portfolios' => ''
                    ]
                ]
                */
            ]
        ],
    ]
];
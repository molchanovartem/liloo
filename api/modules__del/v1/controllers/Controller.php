<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\filters\Cors;
use api\modules\v1\actions\IndexAction;
use api\modules\v1\actions\ViewAction;
use api\modules\v1\actions\CreateAction;
use api\modules\v1\actions\DeleteAction;
use api\modules\v1\actions\UpdateAction;
use api\modules\v1\services\ModelService;

class Controller extends \yii\rest\Controller
{
    /**
     * @var ModelService
     */
    protected $modelService;

    public function init()
    {
        if ($this->modelService instanceof ModelService) {
            $this->modelService->data = [
                'bodyParams' => Yii::$app->request->getBodyParams(),
                'get' => Yii::$app->request->getQueryParams(),
                'post' => Yii::$app->request->post(),
            ];
        }


        Yii::$app->response->headers->set('Access-Control-Allow-Methods', "POST,PUT,PATCH,GET");
        Yii::$app->response->headers->set('Access-Control-Allow-Origin', "*");

        parent::init();
    }

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'corsFilter' => [
                'class' => Cors::class,
                'cors' => [
                    'Origin' => [
                        'http://lilu',
                        'http://localhost:8080'
                    ]
                ]
            ],
        ]);
    }

    /**
     * @return array
     */
    public function actions(): array
    {
        return [
            'index' => [
                'class' => IndexAction::class,
                'modelService' => $this->modelService,
            ],
            'view' => [
                'class' => ViewAction::class,
                'modelService' => $this->modelService
            ],
            'create' => [
                'class' => CreateAction::class,
                'modelService' => $this->modelService
            ],
            'update' => [
                'class' => UpdateAction::class,
                'modelService' => $this->modelService
            ],
            'delete' => [
                'class' => DeleteAction::class,
                'modelService' => $this->modelService
            ]
        ];
    }
}
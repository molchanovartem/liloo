<?php

namespace api\modules\v1\actions;

use Yii;
use yii\web\ServerErrorHttpException;

/**
 * Class CreateAction
 * @package api\modules\v1\actions
 */
class CreateAction extends Action
{
    public function run()
    {
        if (!$this->modelService->create()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }

        Yii::$app->response->setStatusCode(201);
        return $this->modelService->getResult();
    }
}
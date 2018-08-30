<?php

namespace api\modules\v1\actions;

use Yii;
use yii\web\ServerErrorHttpException;

/**
 * Class DeleteAction
 * @package api\modules\v1\actions
 */
class DeleteAction extends Action
{
    public function run($id)
    {
        if (!$this->modelService->delete($id)) {
            throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
        }
        Yii::$app->response->setStatusCode(204);
    }
}
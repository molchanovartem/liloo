<?php

namespace api\modules\v1\actions;

use yii\web\NotFoundHttpException;

/**
 * Class ViewAction
 * @package api\modules\v1\actions
 */
class ViewAction extends Action
{
    public function run($id)
    {
        if (!$this->modelService->view($id)) {
            throw new NotFoundHttpException();
        }

        return $this->modelService->getResult();
    }
}
<?php

namespace api\modules\v1\actions;

use yii\web\UnprocessableEntityHttpException;

/**
 * Class UpdateAction
 * @package api\modules\v1\actions
 */
class UpdateAction extends Action
{
    public function run($id)
    {
        if (!$this->modelService->update($id)) {
            throw new UnprocessableEntityHttpException();
        }

        return $this->modelService->getResult();
    }
}
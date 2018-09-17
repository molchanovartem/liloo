<?php

namespace api\modules\v1\controllers;

use common\models\Convenience;
use yii\rest\ActiveController;

/**
 * Class ConvenienceController
 * @package api\modules\v1\controllers
 */
class ConvenienceController extends ActiveController
{
    /**
     * @var string
     */
    public $modelClass = Convenience::class;

    /**
     * @return array
     */
    public function actions(): array
    {
        $actions = parent::actions();
        unset($actions['create'], $actions['view'], $actions['update'], $actions['delete']);

        return $actions;
    }
}
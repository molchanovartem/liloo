<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use common\models\Specialization;

/**
 * Class SpecializationController
 * @package api\controllers\v1
 */
class SpecializationController extends ActiveController
{
    /**
     * @var string
     */
    public $modelClass = Specialization::class;

    /**
     * @return array
     */
    public function actions(): array
    {
        $actions = parent::actions();
        unset($actions['view'], $actions['create'], $actions['update'], $actions['delete']);

        return $actions;
    }
}
<?php

namespace site\services;

use common\core\service\ModelService;
use common\models\Salon;
use common\models\Specialization;
use common\models\User;
use common\models\UserProfile;
use common\models\UserSpecialization;
use site\forms\FilterForm;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;

class ExecutorService extends ModelService
{
    public function getArrayProvider()
    {
        $query = User::find()
            ->with(['specializations'])
            ->with(['profile'])
            ->asArray()
            ->all();

        $arrayProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->setData(['provider' => $arrayProvider]);
    }

    public function getExecutors()
    {
        $query = $query = User::find()
            ->select('*')
            ->alias('u')
            ->joinWith('specializations')->all();

        $this->setData(['executors' => $query]);
    }
}
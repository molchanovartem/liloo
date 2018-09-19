<?php

namespace site\services;

use common\core\service\ModelService;
use common\models\User;

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

    /**
     * @param $id
     * @throws \Exception
     */
    public function findExecutor($id)
    {
        if (($model = User::find()
                ->with(['specializations'])
                ->with(['profile'])
                ->where(['id' => $id])
                ->one()) == null) throw new \Exception('Not find any recall');

        $this->setData(['executor' => $model]);
    }
}

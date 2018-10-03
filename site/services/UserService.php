<?php

namespace site\services;

use common\core\service\ModelService;
use site\models\User;

class UserService extends ModelService
{
    /**
     * @param $id
     * @throws \Exception
     */
    public function findUser($id)
    {
        if (($model = User::find()
//                ->with(['appointment'])
                ->with(['profile'])
                ->where(['id' => $id])
                ->one()) == null) throw new \Exception('Not find any user');

        $this->setData(['model' => $model]);
    }
}

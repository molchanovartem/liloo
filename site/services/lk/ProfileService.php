<?php

namespace site\services\lk;

use common\core\service\ModelService;
use common\models\User;

/**
 * Class ProfileService
 *
 * @package site\services\lk
 */
class ProfileService extends ModelService
{
    /**
     * @param $id
     *
     * @throws \Exception
     */
    public function findUser($id)
    {
        if (($model = User::find()
                          ->with(['profile'])
                          ->where(['id' => $id])
                          ->one()) == null) throw new \Exception('Not find any user');

        $this->setData(['model' => $model]);
    }
}
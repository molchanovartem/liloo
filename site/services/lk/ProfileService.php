<?php

namespace site\services\lk;

use common\core\service\ModelService;
use common\models\User;
use common\models\UserProfile;

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

    /**
     * @param $id
     * @return bool
     */
    public function update($id)
    {
        $model = UserProfile::find()->where(['user_id' => $id])->one();

        $this->setData(['model' => $model]);

        return $model->load($this->getData('post')) && $model->save();
    }
}
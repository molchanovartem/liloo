<?php

namespace api\services;

use api\models\User;
use api\models\UserProfile;

/**
 * Class UserLoginService
 * @package api\services
 */
class UserLoginService extends Service
{
    public function login(array $attributes)
    {
        $user = $this->getUser($attributes['phone'], $attributes['password']);
        if (count($user)) {

        }

        return false;
    }

    /**
     * @param $phone
     * @param $password
     * @return array|null|\yii\db\ActiveRecord
     */
    private function getUser($phone, $password)
    {
        return User::find()
            ->alias('u')
            ->leftJoin(UserProfile::tableName() . ' up', 'up.user_id = u.id')
            ->where(['u.password' => md5($password)])
            ->andWhere(['up.phone' => $phone])
            ->one();
    }
}
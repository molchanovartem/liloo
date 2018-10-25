<?php

namespace site\models;

use yii\web\IdentityInterface;
use common\models\UserProfile;

/**
 * Class User
 * @package site\models
 */
class User extends \common\models\User implements IdentityInterface
{
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int|string $id
     *
     * @return null|static
     */
    public static function findIdentity($id)
    {
        return User::findOne($id);
    }

    /**
     * @param $phone
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function findByPhone($phone)
    {
        return User::find()
            ->alias('u')
            ->leftJoin(UserProfile::tableName() . ' up', 'up.user_id = u.id')
            ->where(['up.phone' => $phone])
            ->one();
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }
}

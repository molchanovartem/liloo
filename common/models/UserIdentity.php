<?php

namespace common\models;

use yii\web\IdentityInterface;

/**
 * Class UserIdentity
 * @package common\models
 */
class UserIdentity extends User implements IdentityInterface
{
    public static function findIdentity($id)
    {
        // TODO: Implement findIdentity() method.
        return self::find()
            ->one();
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::find()
            ->one();
    }

    public function getId()
    {
        return $this->id;
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
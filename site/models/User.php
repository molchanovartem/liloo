<?php

namespace site\models;

use yii\web\IdentityInterface;

class User extends \common\models\User implements IdentityInterface
{
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

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

    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }

    public static function findByLogin($login)
    {
        return User::find()->where(['login' => $login])->one();
    }

    public function validatePassword($password)
    {
        return ($this->password == $password) ? true : false;
    }
}
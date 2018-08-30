<?php

namespace api\models;

use api\queries\UserQuery;

/**
 * Class User
 * @package api\models
 */
class User extends \common\models\User
{
    /**
     * @return UserQuery|\common\queries\UserQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }
}
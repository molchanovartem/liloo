<?php

namespace api\models;

use api\queries\UserServiceQuery;

/**
 * Class UserService
 *
 * @package api\models
 */
class UserService extends \common\models\UserService
{
    /**
     * @return UserServiceQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new UserServiceQuery(get_called_class());
    }
}
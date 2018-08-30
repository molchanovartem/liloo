<?php

namespace api\models;

use api\queries\UserProfileQuery;

/**
 * Class USerProfile
 *
 * @package api\models
 */
class UserProfile extends \common\models\UserProfile
{
    /**
     * @return UserProfileQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new UserProfileQuery(get_called_class());
    }
}
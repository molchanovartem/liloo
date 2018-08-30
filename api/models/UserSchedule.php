<?php

namespace api\models;

use api\queries\UserScheduleQuery;

/**
 * Class UserSchedule
 *
 * @package api\models
 */
class UserSchedule extends \common\models\UserSchedule
{
    /**
     * @return UserScheduleQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new UserScheduleQuery(get_called_class());
    }
}
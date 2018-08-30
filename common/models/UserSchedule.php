<?php

namespace common\models;

use common\queries\UserScheduleQuery;
use yii\db\ActiveRecord;

/**
 * Class UserSchedule
 * @package common\models
 */
class UserSchedule extends ActiveRecord
{
    public static function tableName()
    {
        return "{{%user_schedule}}";
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['user_id', 'type', 'start_date', 'end_date'], 'required'],
            [['user_id', 'type'], 'integer'],
            [['start_date', 'end_date'], 'date', 'format' => 'php:Y-m-d H:i:s']
        ];
    }

    public static function find()
    {
        return new UserScheduleQuery(get_called_class());
    }
}
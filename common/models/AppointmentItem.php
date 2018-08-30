<?php

namespace common\models;

use yii\db\ActiveRecord;
use common\behaviors\AccountBehavior;
use common\queries\AppointmentItemQuery;

/**
 * Class AppointmentItem
 *
 * @package common\models
 */
class AppointmentItem extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%appointment_item}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['appointment_id', 'service_id', 'service_name', 'service_price', 'service_duration', 'quantity'], 'required'],
            [['appointment_id', 'service_id', 'service_duration', 'quantity'], 'integer'],
            ['service_price', 'number'],
            ['service_name', 'string', 'max' => 255]
        ];
    }

    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            AccountBehavior::class
        ];
    }

    /**
     * @return AppointmentItemQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new AppointmentItemQuery(get_called_class());
    }
}
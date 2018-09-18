<?php

namespace common\models;

use yii\db\ActiveRecord;
use common\queries\Query;

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
    public static function tableName(): string
    {
        return '{{%appointment_item}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['account_id', 'appointment_id', 'service_id', 'service_name', 'service_price', 'service_duration', 'quantity'], 'required'],
            [['account_id', 'appointment_id', 'service_id', 'service_duration', 'quantity'], 'integer'],
            [['service_price', 'service_duration'], 'number', 'min' => 0],
            ['quantity', 'number', 'min' => 1],
            ['service_name', 'string', 'max' => 255]
        ];
    }

    /**
     * @return Query|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new Query(get_called_class());
    }
}
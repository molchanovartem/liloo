<?php

namespace common\models;

use common\behaviors\AccountBehavior;
use common\behaviors\UserId;
use common\queries\AppointmentQuery;
use yii\db\ActiveRecord;

/**
 * Class Appointment
 * @package common\models
 */
class Appointment extends ActiveRecord
{
    const STATUS_NEW = 1;
    const STATUS_NOT_CONFIRMED = 2;
    const STATUS_CONFIRMED = 3;
    const STATUS_CANCELED = 4;

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%appointment}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        /*
 * @todo
 * Валидация client_id, salon_id, start_date, end_date
 * start_date и end_date проверять промежуток
 */
        return [
            [['account_id', 'owner_id', 'client_id', 'status', 'start_date', 'end_date'], 'required'],
            [['account_id', 'user_id', 'salon_id', 'master_id', 'client_id', 'owner_id'], 'integer'],
            [['start_date', 'end_date'], 'date', 'format' => 'php:Y-m-d H:i:s'],
            ['status', 'in', 'range' => array_keys(self::getStatusList())]
        ];
    }

    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            [
                'class' => UserId::class,
                'attribute' => 'owner_id'
            ],
            AccountBehavior::class
        ];
    }

    /**
     * @return array
     */
    public static function getStatusList(): array
    {
        return [
            self::STATUS_NEW => 'New',
            self::STATUS_NOT_CONFIRMED => 'Not confirmed',
            self::STATUS_CONFIRMED => 'Confirmed',
            self::STATUS_CANCELED => 'Canceled'
        ];
    }

    /**
     * @return AppointmentQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new AppointmentQuery(get_called_class());
    }
}
<?php

namespace common\models;

use yii\db\ActiveRecord;
use common\queries\Query;

/**
 * Class Appointment
 *
 * @package common\models
 */
class Appointment extends ActiveRecord
{
    const STATUS_COMPLETED = 1;
    const STATUS_NEW = 2;
    const STATUS_CONFIRMED = 3;
    const STATUS_CANCELED = 4;
    const STATUS_NOT_COME = 5;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%appointment}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['account_id', 'client_id', 'status', 'start_date', 'end_date'], 'required'],
            [['account_id', 'user_id', 'salon_id', 'master_id', 'client_id'], 'integer'],
            [['start_date', 'end_date'], 'date', 'format' => 'php:Y-m-d H:i:s'],
            ['status', 'in', 'range' => array_keys(self::getStatusList())],
            ['start_date', function ($attribute, $params) {
                if (date($this->$attribute) === date($this->end_date)) {
                    $this->addError($attribute, '"start_date" равна "end_date"');
                }
            }],
            ['start_date', function ($attribute) {
                if (date($this->$attribute) > date($this->end_date)) {
                    $this->addError($attribute, '"start_date" больше "end_date"');
                }
            }],
            ['end_date', function ($attribute) {
                if (date($this->$attribute) < date($this->start_date)) {
                    $this->addError($attribute, '"end_date" меньше "start_date"');
                }
            }],
        ];
    }

    /**
     * @return array
     */
    public static function getStatusList(): array
    {
        return [
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_NEW => 'New',
            self::STATUS_CONFIRMED => 'Confirmed',
            self::STATUS_CANCELED => 'Canceled',
            self::STATUS_NOT_COME => 'Not come',
        ];
    }

    /**
     * @return Query|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new Query(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::class, ['id' => 'client_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppointmentItems()
    {
        return $this->hasMany(AppointmentItem::class, ['appointment_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalon()
    {
        return $this->hasOne(Salon::class, ['id' => 'salon_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecalls()
    {
        return $this->hasMany(Recall::class, ['appointment_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserProfile()
    {
        return $this->hasOne(UserProfile::class, ['user_id' => 'user_id']);
    }
}

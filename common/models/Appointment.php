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
    const STATUS_NEW = 1;
    const STATUS_NOT_CONFIRMED = 2;
    const STATUS_CONFIRMED = 3;
    const STATUS_CANCELED = 4;

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
            self::STATUS_NEW => 'New',
            self::STATUS_NOT_CONFIRMED => 'Not confirmed',
            self::STATUS_CONFIRMED => 'Confirmed',
            self::STATUS_CANCELED => 'Canceled'
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
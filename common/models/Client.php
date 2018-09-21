<?php

namespace common\models;

use Yii;
use common\queries\Query;

/**
 * Class Client
 * @package common\models
 */
class Client extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_NOT_ACTIVE = 2;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%client}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['account_id', 'country_id', 'status', 'name'], 'required'],
            [['account_id', 'user_id', 'country_id', 'city_id', 'status', 'total_appointment', 'total_failure_appointment'], 'integer'],
            [['total_spent_money'], 'number'],
            [['surname', 'name', 'patronymic', 'address'], 'string', 'max' => 255],
            ['phone', 'string', 'max' => 20],
            [['date_birth', 'date_last_appointment'], 'date', 'format' => 'php:Y-m-d'],
            ['status', 'in', 'range' => array_keys(self::getStatusList())]
        ];
    }

    /**
     * @return array
     */
    public static function modelAttributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'account_id' => Yii::t('app', 'Account'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return self::modelAttributeLabels();
    }

    /**
     * @return array
     */
    public static function getStatusList(): array
    {
        return [
            self::STATUS_ACTIVE => Yii::t('app', 'Active'),
            self::STATUS_NOT_ACTIVE => Yii::t('app', 'Active'),
        ];
    }

    /**
     * @return string
     */
    public function getStatusName(): string
    {
        return self::getStatusList()[$this->status];
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
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}

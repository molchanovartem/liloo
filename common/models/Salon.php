<?php

namespace common\models;

use Yii;
use common\queries\Query;

/**
 * Class Salon
 * @package common\models
 */
class Salon extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_NOT_ACTIVE = 2;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%salon}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        /*
         * @todo
         * Добавить проверку 'country_id', 'city_id'
         */

        return [
            [['account_id', 'user_id', 'country_id', 'city_id', 'status', 'name'], 'required'],
            [['account_id', 'user_id', 'country_id', 'city_id', 'status', 'phone'], 'integer'],
            [['latitude', 'longitude'], 'number'],
            [['name', 'address'], 'string', 'max' => 255],
            ['description', 'string', 'max' => 1000],
            ['status', 'in', 'range' => array_keys(self::getStatusList())],
            ['description', 'string'],
            ['phone', 'string', 'max' => 15]
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
            'user_id' => Yii::t('app', 'Owner ID'),
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
     * @return mixed
     */
    public function getStatusName()
    {
        return self::getStatusList()[$this->status];
    }

    /**
     * @return array
     */
    public static function getStatusList()
    {
        return [
            self::STATUS_ACTIVE => Yii::t('app', 'Active'),
            self::STATUS_NOT_ACTIVE => Yii::t('app', 'Not active'),
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
    public function getClients()
    {
        return $this->hasMany(Client::className(), ['salon_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalonSpecializations()
    {
        return $this->hasMany(SalonSpecialization::className(), ['salon_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpecializations()
    {
        return $this->hasMany(Specialization::className(), ['id' => 'specialization_id'])
            ->viaTable('{{%salon_specialization}}', ['salon_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMasters()
    {
        return $this->hasMany(Master::className(), ['id' => 'master_id'])->viaTable('{{%salon_master}}', ['salon_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServices()
    {
        return $this->hasMany(Service::className(), ['salon_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConveniences()
    {
        return $this->hasMany(Convenience::className(), ['id' => 'convenience_id'])
            ->viaTable('{{%salon_convenience}}', ['salon_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    /*
     * @todo
     * переименовать в getMasterSchedules()
     */
    public function getSchedules()
    {
        return $this->hasMany(MasterSchedule::class, ['master_id' => 'master_id'])
            ->viaTable('{{%salon_master}}', ['salon_id' => 'id']);
    }
}

<?php

namespace common\models;

use common\behaviors\AccountBehavior;
use common\behaviors\UserId;
use common\queries\SalonQuery;
use Yii;

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
            [['account_id', 'user_id', 'country_id', 'city_id', 'status'], 'integer'],
            [['name', 'address'], 'string', 'max' => 255],
            ['status', 'in', 'range' => array_keys(self::getStatusList())]
        ];
    }

    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            UserId::class,
            AccountBehavior::class,
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
     * @return \yii\db\ActiveQuery
     */
    public function getClients()
    {
        return $this->hasMany(Client::className(), ['salon_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
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
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('{{%salon_user}}', ['salon_id' => 'id']);
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
     * @return SalonQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new SalonQuery(get_called_class());
    }

    public static function deleteById(int $id)
    {
        return self::deleteAll([
            'id' => $id,
            'account_id' => Yii::$app->account->getId()
        ]);
    }
}

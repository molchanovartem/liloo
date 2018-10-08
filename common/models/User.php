<?php

namespace common\models;

use Yii;
use common\queries\Query;

/**
 * Class User
 * @package common\models
 */
class User extends \yii\db\ActiveRecord
{
    const TYPE_MASTER = 1;
    const TYPE_CLIENT = 2;

    const STATUS_ACTIVE = 1;
    const STATUS_NOT_ACTIVE = 0;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%user}}';
    }

   /**
     * @return array
     */
    public function rules(): array
    {
        /*
         * @todo
         * Доьбавить проверку: type, status range
         */

        return [
            [['account_id', 'type', 'status', 'login', 'password', 'refresh_token'], 'required'],
            [['account_id', 'type', 'status'], 'integer'],
            [['login', 'password', 'token', 'refresh_token'], 'string', 'max' => 255],
            ['status', 'default', 'value' => self::STATUS_NOT_ACTIVE]
        ];
    }

    /**
     * @return array
     */
    public static function modelAttributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
            'login' => Yii::t('app', 'Login'),
            'password' => Yii::t('app', 'Password'),
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
     * @return Query|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new Query(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(UserProfile::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpecializations()
    {
        return $this->hasMany(Specialization::className(), ['id' => 'specialization_id'])
            ->viaTable('{{%user_specialization}}', ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConveniences()
    {
        return $this->hasMany(Convenience::className(), ['id' => 'convenience_id'])
            ->viaTable('{{%user_convenience}}', ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchedules()
    {
        return $this->hasMany(UserSchedule::class, ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccount()
    {
        return $this->hasOne(Account::class, ['id' => 'account_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecalls()
    {
        return $this->hasMany(Recall::class, ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppointments()
    {
        return $this->hasMany(Appointment::class, ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClients()
    {
        return $this->hasMany(Client::class, ['user_id' => 'id']);
    }
}

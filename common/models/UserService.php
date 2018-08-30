<?php

namespace common\models;

use common\queries\UserServiceQuery;
use Yii;

/**
 * Class UserService
 *
 * @package common\models
 */
class UserService extends \yii\db\ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%user_service}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['account_id', 'user_id', 'service_id', 'salon_id'], 'required'],
            [['account_id', 'user_id', 'service_id', 'salon_id'], 'integer'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'salon_id' => Yii::t('app', 'Salon'),
            'user_id' => Yii::t('app', 'User'),
            'service_id' => Yii::t('app', 'Service'),
        ];
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalon()
    {
        return $this->hasOne(Salon::className(), ['id' => 'salon_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(Service::className(), ['id' => 'service_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function find()
    {
        return new UserServiceQuery(get_called_class());
    }
}

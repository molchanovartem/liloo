<?php

namespace common\models;

use Yii;
use common\queries\Query;

/**
 * Class UserProfile
 * @package common\models
 */
class UserProfile extends \yii\db\ActiveRecord
{
    public $avatarDelete;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%user_profile}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['user_id', 'name', 'phone'], 'required'],
            [['user_id', 'phone'], 'integer'],
            [['date_birth'], 'date', 'format' => 'php: Y-m-d'],
            [['surname', 'name', 'patronymic'], 'string', 'max' => 255],
            [['avatar'], 'image'],
            [['avatarDelete'], 'integer'],
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
            'user_id' => Yii::t('app', 'User'),
            'surname' => Yii::t('app', 'Surname'),
            'name' => Yii::t('app', 'Name'),
            'patronymic' => Yii::t('app', 'Patronymic'),
            'date_birth' => Yii::t('app', 'Date birth'),
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
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public static function find()
    {
        return new Query(get_called_class());
    }

}

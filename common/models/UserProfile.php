<?php

namespace common\models;

use Yii;
use common\validators\CityExistValidator;
use common\validators\CountryExistValidator;
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
            [['user_id', 'country_id', 'city_id'], 'integer'],
            [['date_birth'], 'date', 'format' => 'php: Y-m-d'],
            [['surname', 'name', 'patronymic', 'address'], 'string', 'max' => 255],
            [['latitude', 'longitude'], 'number'],
            ['phone', 'unique'],

            ['country_id', CountryExistValidator::class],
            ['city_id', CityExistValidator::class],

            [['avatar'], 'image'],
            [['avatarDelete'], 'integer'],

            ['description', 'string'],

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
            'surname' => Yii::t('app', 'Фамилия'),
            'name' => Yii::t('app', 'Имя'),
            'patronymic' => Yii::t('app', 'Patronymic'),
            'date_birth' => Yii::t('app', 'Дата рождения'),
            'phone' => Yii::t('app', 'Телефон'),
            'city_id' => Yii::t('app', 'Город'),
            'country_id' => Yii::t('app', 'Страна'),
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
    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::class, ['id' => 'country_id']);
    }
}

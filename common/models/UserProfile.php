<?php

namespace common\models;

use Yii;
use common\queries\UserProfileQuery;

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
            [['user_id', 'phone'], 'required'],
            [['user_id'], 'integer'],
            [['date_birth'], 'date', 'format' => 'php: Y-m-d'],
            [['surname', 'name', 'patronymic'], 'string', 'max' => 255],
            [['avatar'], 'image'],
            [['avatarDelete'], 'integer'],
            ['description', 'string'],
            ['phone', 'string', 'max' => 15]
        ];
    }

    public function behaviors()
    {
        return [
            /*
            [
                'class' => ActionImage::class,
                'attribute' => 'avatar',
                'deleteAttribute' => 'avatarDelete',
                'path' => '@webroot/public/uploads',
                'pathUrl' => '@web/public/uploads'
            ]
            */
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

    /**
     * @return \yii\db\ActiveQuery
     */
    /*
    public function getSpecializations()
    {
        return $this->hasMany(Specialization::className(), ['id' => 'specialization_id'])
            ->viaTable('{{%user_specialization}}', ['user_id' => 'user_id']);
    }
    */

    /**
     * @return \yii\db\ActiveQuery
     */
    /*
    public function getConveniences()
    {
        return $this->hasMany(Convenience::className(), ['id' => 'convenience_id'])
            ->viaTable('{{%user_convenience}}', ['user_id' => 'user_id']);
    }
    */

    public static function find()
    {
        return new UserProfileQuery(get_called_class());
    }

}

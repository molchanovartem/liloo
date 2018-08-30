<?php

namespace common\models;

use common\queries\SpecializationQuery;
use Yii;

/**
 * Class Specialization
 * @package common\models
 */
class Specialization extends \yii\db\ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%specialization}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @return array
     */
    public static function modelAttributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
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
    public function getServices()
    {
        return $this->hasMany(Service::className(), ['specialization_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserSpecializations()
    {
        return $this->hasMany(UserSpecialization::className(), ['specialization_id' => 'id']);
    }

    public static function find()
    {
        return new SpecializationQuery(get_called_class());
    }
}

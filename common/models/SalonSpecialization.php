<?php

namespace common\models;

use Yii;
use api\queries\Query;

/**
 * Class SalonSpecialization
 * @package common\models
 */
class SalonSpecialization extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%salon_specialization}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account_id', 'salon_id', 'specialization_id'], 'required'],
            [['account_id', 'salon_id', 'specialization_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'salon_id' => Yii::t('app', 'Salon ID'),
            'specialization_id' => Yii::t('app', 'Specialization ID'),
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
    public function getSpecialization()
    {
        return $this->hasOne(Specialization::className(), ['id' => 'specialization_id']);
    }

    public static function find()
    {
        return new Query(get_called_class());
    }
}

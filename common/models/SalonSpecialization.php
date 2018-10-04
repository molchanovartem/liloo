<?php

namespace common\models;

use common\queries\Query;
use Yii;

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
     * @return Query|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new Query(get_called_class());
    }
}

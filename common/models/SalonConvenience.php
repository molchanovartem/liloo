<?php

namespace common\models;

use Yii;
use common\queries\Query;

/**
 * Class SalonConvenience
 * @package common\models
 */
class SalonConvenience extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%salon_convenience}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account_id', 'salon_id', 'convenience_id'], 'required'],
            [['account_id', 'salon_id', 'convenience_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'salon_id' => Yii::t('app', 'Salon ID'),
            'convenience_id' => Yii::t('app', 'Convenience ID'),
        ];
    }

    public static function find()
    {
        return new Query(get_called_class());
    }
}

<?php

namespace common\models;

use yii\db\ActiveRecord;
use common\queries\Query;

/**
 * Class SalonService
 *
 * @package common\models
 */
class SalonService extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%salon_service}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['account_id', 'salon_id', 'service_id', 'service_price', 'service_duration'], 'required'],
            [['account_id', 'salon_id', 'service_id', 'service_duration'], 'integer'],
            [['service_price'], 'number'],
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
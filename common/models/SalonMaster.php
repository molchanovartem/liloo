<?php

namespace common\models;

use common\queries\Query;

/**
 * Class SalonMaster
 *
 * @package common\models
 */
class SalonMaster extends \yii\db\ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%salon_master}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['account_id', 'salon_id', 'master_id'], 'required'],
            [['account_id', 'salon_id', 'master_id'], 'integer']
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
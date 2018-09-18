<?php

namespace common\models;

use common\queries\Query;

/**
 * Class MasterSpecialization
 *
 * @package common\models
 */
class MasterSpecialization extends \yii\db\ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%master_specialization}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['account_id', 'master_id', 'specialization_id'], 'required'],
            [['account_id', 'master_id', 'specialization_id'], 'integer']
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
<?php

namespace common\models;

use common\behaviors\AccountBehavior;
use common\queries\MasterSpecializationQuery;

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
     * @return array
     */
    public function behaviors(): array
    {
        return [
            AccountBehavior::class
        ];
    }

    public static function find()
    {
        return new MasterSpecializationQuery(get_called_class());
    }
}
<?php

namespace common\models;

use yii\db\ActiveRecord;
use common\queries\Query;

/**
 * Class MasterService
 *
 * @package common\models
 */
class MasterService extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%master_service}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['account_id', 'master_id', 'service_id', 'salon_id'], 'required'],
            [['account_id', 'master_id', 'service_id', 'salon_id'], 'integer']
        ];
    }

    public static function find()
    {
        return new Query(get_called_class());
    }
}
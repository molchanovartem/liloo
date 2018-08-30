<?php

namespace common\models;

use common\behaviors\AccountBehavior;
use common\queries\MasterServiceQuery;
use yii\db\ActiveRecord;

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
        return new MasterServiceQuery(get_called_class());
    }
}
<?php

namespace common\models;

use common\behaviors\AccountBehavior;
use common\queries\Query;

/**
 * Class AccountTariff
 * @package common\models
 */
class AccountTariff extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account_tariff}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account_id', 'tariff_id', 'end_date'], 'required'],
            [['account_id', 'tariff_id'], 'integer'],
            [['end_date'], 'date', 'format' => 'php:Y-m-d H:i:s'],
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

    /**
     * @return Query|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new Query(get_called_class());
    }
}
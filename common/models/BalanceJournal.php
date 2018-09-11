<?php

namespace common\models;

/**
 * Class BalanceJournal
 * @package app\components\balance
 */
class BalanceJournal extends \yii\db\ActiveRecord
{
    const BALANCE_DECREASE = 0;
    const BALANCE_INCREASE = 1;

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%balance_journal}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['account_id', 'type_operation', 'sum', 'reason'], 'required'],
            [['account_id', 'type_operation'], 'integer'],
            [['sum'], 'number'],
            [['reason'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'account_id' => 'ID аккаунта',
            'sum' => 'Сумма',
            'type_operation' => 'Тип операции',
            'reason' => 'Причина',
        ];
    }
}

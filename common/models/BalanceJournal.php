<?php

namespace common\models;

use common\queries\Query;

/**
 * Class BalanceJournal
 * @package common\models
 */
class BalanceJournal extends \yii\db\ActiveRecord
{
    const TYPE_OPERATION_DECREASE = 1;
    const TYPE_OPERATION_INCREASE = 2;

    const TYPE_REASON_SELL_TARIFF = 1;

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
            [['account_id', 'type_operation', 'sum', 'type_reason', 'data_reason', 'start_sum', 'end_sum'], 'required'],
            [['account_id', 'type_operation', 'type_reason'], 'integer'],
            [['sum', 'start_sum', 'end_sum'], 'number'],
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
        ];
    }

    /**
     * @return array
     */
    public function getTypesOperation()
    {
        return [
            self::TYPE_OPERATION_DECREASE => 'Снятие',
            self::TYPE_OPERATION_INCREASE => 'Пополнение',
        ];
    }

    /**
     * @return mixed
     */
    public function getTypeOperationName()
    {
        return $this->getTypesOperation()[$this->type_operation];
    }

    /**
     * @return array
     */
    public function getTypesReason()
    {
        return [
            self::TYPE_REASON_SELL_TARIFF => 'Покупка тарифа',
        ];
    }

    /**
     * @return mixed
     */
    public function getTypeReasonName()
    {
        return $this->getTypesReason()[$this->type_reason];
    }

    /**
     * @return Query|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new Query(get_called_class());
    }
}

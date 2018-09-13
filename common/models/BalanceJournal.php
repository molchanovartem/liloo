<?php

namespace common\models;

/**
 * Class BalanceJournal
 * @package app\components\balance
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
            [['account_id', 'type_operation', 'sum', 'type_reason', 'data_reason'], 'required'],
            [['account_id', 'type_operation', 'type_reason'], 'integer'],
            [['sum'], 'number'],
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
     * @param $typeOperation
     * @return mixed
     */
    public function getTypeOperation($typeOperation)
    {
        return $this->getTypesOperation()[$typeOperation];
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
     * @param $typeReason
     * @return mixed
     */
    public function getTypeReason($typeReason)
    {
        return $this->getTypesOperation()[$typeReason];
    }
}

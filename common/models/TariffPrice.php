<?php

namespace common\models;

use common\queries\Query;

/**
 * Class TariffPrice
 * @package common\models
 */
class TariffPrice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tariff_price}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['day', 'tariff_id', 'price'], 'required'],
            [['day', 'tariff_id'], 'integer'],
            [['price'], 'number'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'day' => 'Количество дней',
            'price' => 'Цена',
            'tariff_id' => 'Тариф',
        ];
    }

    /**
     * @return Query|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new Query(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTariff()
    {
        return $this->hasOne(Tariff::class, ['id' => 'tariff_id']);
    }
}
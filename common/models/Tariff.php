<?php

namespace common\models;

class Tariff extends \yii\db\ActiveRecord
{
    const TARIFF_STATUS_INACTIVE = 0;
    const TARIFF_STATUS_ACTIVE = 1;

    const TARIFF_TYPE_MASTER = 0;
    const TARIFF_TYPE_SALON = 1;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%tariff}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['name', 'type', 'status'], 'required'],
            [['type', 'status', 'quantity'], 'integer'],
            [['name', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название тарифа',
            'description' => 'Описание',
            'type' => 'Тип',
            'status' => 'Статус',
            'quantity' => 'Количество использований',
        ];
    }

    /**
     * @return array
     */
    public function getStatuses()
    {
        return [
            self::TARIFF_STATUS_INACTIVE => 'Неактивный',
            self::TARIFF_STATUS_ACTIVE => 'Активный',
        ];
    }

    /**
     * @param $status
     * @return mixed
     */
    public function getStatus($status)
    {
        return $this->getStatuses()[$status];
    }

    /**
     * @return array
     */
    public static function getTypes()
    {
        return [
            self::TARIFF_TYPE_MASTER => 'Мастер',
            self::TARIFF_TYPE_SALON => 'Салон',
        ];
    }

    /**
     * @param $type
     * @return mixed
     */
    public function getType($type)
    {
        return self::getTypes()[$type];
    }
}
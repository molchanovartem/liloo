<?php

namespace common\models;

use admin\forms\TariffForm;

class Tariff extends \yii\db\ActiveRecord
{
    const TARIFF_STATUS_INACTIVE = 0;
    const TARIFF_STATUS_ACTIVE = 1;

    const TARIFF_TYPE_MASTER = 0;
    const TARIFF_TYPE_SALON = 1;

    private $access;

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
            [['name', 'type', 'status', 'access'], 'required'],
            [['type', 'status', 'quantity'], 'integer'],
            [['name', 'description', 'access'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return self::getAttributeLabels();
    }

    /**
     * @return array
     */
    public static function getAttributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название тарифа',
            'description' => 'Описание',
            'type' => 'Тип',
            'status' => 'Статус',
            'quantity' => 'Количество использований',
            'access' => 'Доступы',
        ];
    }

    public function getAccessArray($data)
    {
        return explode('/', $data);
    }

    public function getTariffAccessName($tariff)
    {
        return TariffForm::getTariffAccessList()[$tariff];
    }

    /**
     * @return array
     */
    public function getStatuses()
    {
        return self::getStatusList();
    }

    /**
     * @return array
     */
    public static function getStatusList()
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
    public function getTypes()
    {
        return self::getTypeList();
    }

    /**
     * @return array
     */
    public static function getTypeList()
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

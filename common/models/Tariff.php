<?php

namespace common\models;

use common\queries\Query;
use admin\forms\TariffForm;

/**
 * Class Tariff
 *
 * @package common\models
 */
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

    /**
     * @param $data
     * @return array
     */
//    public function getAccessArray($data)
//    {
//        return explode('/', $data);
//    }

    /**
     * @param $tariff
     * @return mixed
     */
//    public function getTariffAccessName($tariff)
//    {
//        return TariffForm::getTariffAccessList()[$tariff];
//    }

    /**
     * @return array
     */
//    public function getStatuses()
//    {
//        return self::getStatusList();
//    }

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
    public function getStatusName()
    {
        return self::getStatusList()[$this->status];
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
    public function getTypeName()
    {
        return self::getTypeList()[$this->type];
    }

    /**
     * @return Query|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new Query(get_called_class());
    }
}

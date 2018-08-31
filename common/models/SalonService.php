<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use common\behaviors\AccountBehavior;
use common\queries\SalonServiceQuery;
use common\validators\SalonExistValidator;
use common\validators\ServiceExistValidator;

/**
 * Class SalonService
 *
 * @package common\models
 */
class SalonService extends ActiveRecord
{
    const SCENARIO_BATCH = 'batch';

    /**
     * @return array
     */
    public function scenarios()
    {
        $defaultAttributes = ['account_id', 'salon_id', 'service_id', 'service_price', 'service_duration'];
        return [
            self::SCENARIO_DEFAULT => $defaultAttributes,
            self::SCENARIO_BATCH => $defaultAttributes
        ];
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%salon_service}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['account_id', 'salon_id', 'service_id', 'service_price', 'service_duration'], 'required'],
            [['account_id', 'salon_id', 'service_id', 'service_duration'], 'integer'],
            [['service_price'], 'number'],
            ['salon_id', SalonExistValidator::class, 'on' => self::SCENARIO_DEFAULT],
            ['service_id', ServiceExistValidator::class, 'on' => self::SCENARIO_DEFAULT]
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            AccountBehavior::class
        ];
    }

    /**
     * @return SalonServiceQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new SalonServiceQuery(get_called_class());
    }

    /**
     * @param int $id
     * @return int
     */
    public static function deleteById(int $id)
    {
        return self::deleteAll([
            'account_id' => Yii::$app->account->getId(),
            'id' => $id,
        ]);
    }
}
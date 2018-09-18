<?php

namespace api\models;

use Yii;
use api\queries\SalonServiceQuery;
use api\validators\SalonExistValidator;
use api\validators\ServiceExistValidator;
use common\behaviors\AccountBehavior;

/**
 * Class SalonService
 *
 * @package api\models
 */
class SalonService extends \common\models\SalonService
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
     * @return array
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            ['salon_id', SalonExistValidator::class, 'on' => self::SCENARIO_DEFAULT],
            ['service_id', ServiceExistValidator::class, 'on' => self::SCENARIO_DEFAULT]
        ]);
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
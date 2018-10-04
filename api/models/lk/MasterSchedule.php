<?php

namespace api\models\lk;

use Yii;
use common\behaviors\AccountBehavior;
use api\validators\MasterExistValidator;
use api\validators\MasterScheduleValidator;
use api\validators\SalonExistValidator;

/**
 * Class MasterSchedule
 *
 * @package api\models\lk
 */
class MasterSchedule extends \common\models\MasterSchedule
{
    const SCENARIO_BATCH = 'batch';

    /**
     * @return array
     */
    public function scenarios()
    {
        $defaultAttributes = ['account_id', 'master_id', 'salon_id', 'type', 'start_date', 'end_date', 'item'];

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
            ['salon_id', SalonExistValidator::class],
            ['master_id', MasterExistValidator::class],
            ['item', MasterScheduleValidator::class, 'on' => self::SCENARIO_DEFAULT],
        ]);
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
     * @return array
     */
    public function getItem(): array
    {
        return [[
            'id' => $this->id,
            'master_id' => $this->master_id,
            'salon_id' => $this->salon_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ]];
    }

    /**
     * @param int $id
     * @return int
     */
    public static function deleteById(int $id)
    {
        return self::deleteAll([
            'id' => $id,
            'account_id' => Yii::$app->account->getId()
        ]);
    }
}
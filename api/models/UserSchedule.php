<?php

namespace api\models;

use Yii;
use common\behaviors\UserId;
use api\queries\UserScheduleQuery;
use api\validators\UserScheduleValidator;

/**
 * Class UserSchedule
 *
 * @package api\models
 */
class UserSchedule extends \common\models\UserSchedule
{
    const SCENARIO_BATCH = 'batch';

    /**
     * @return array
     */
    public function scenarios()
    {
        $defaultAttributes = ['user_id', 'type', 'start_date', 'end_date', 'item'];

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
            ['item', UserScheduleValidator::class, 'on' => self::SCENARIO_DEFAULT],
        ]);
    }

    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            UserId::class
        ];
    }

    /**
     * @return UserScheduleQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new UserScheduleQuery(get_called_class());
    }

    /**
     * @return array
     */
    public function getItem(): array
    {
        return [[
            'id' => $this->id,
            'user_id' => $this->user_id,
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
            'user_id' => Yii::$app->user->getId()
        ]);
    }
}
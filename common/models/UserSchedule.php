<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use common\behaviors\UserId;
use common\validators\UserScheduleValidator;
use common\queries\UserScheduleQuery;

/**
 * Class UserSchedule
 * @package common\models
 */
class UserSchedule extends ActiveRecord
{
    const TYPE_WORKING = 1;

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
     * @return string
     */
    public static function tableName(): string
    {
        return "{{%user_schedule}}";
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['user_id', 'type', 'start_date', 'end_date'], 'required'],
            [['user_id', 'type'], 'integer'],
            [['start_date', 'end_date'], 'date', 'format' => 'php:Y-m-d H:i:s'],
            ['type', 'in', 'range' => array_keys(self::getTypeList())],
            ['item', UserScheduleValidator::class, 'on' => self::SCENARIO_DEFAULT],
            ['start_date', function ($attribute, $params) {
                if (date($this->$attribute) === date($this->end_date)) {
                    $this->addError($attribute, '"start_date" равна "end_date"');
                }
            }],
            ['start_date', function ($attribute) {
                if (date($this->$attribute) > date($this->end_date)) {
                    $this->addError($attribute, '"start_date" больше "end_date"');
                }
            }],
            ['end_date', function ($attribute) {
                if (date($this->$attribute) < date($this->start_date)) {
                    $this->addError($attribute, '"end_date" меньше "start_date"');
                }
            }]
        ];
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
     * @return array
     */
    public static function getTypeList(): array
    {
        return [
            self::TYPE_WORKING => 'working'
        ];
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
     * @return UserScheduleQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new UserScheduleQuery(get_called_class());
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
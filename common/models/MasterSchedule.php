<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use common\validators\MasterExistValidator;
use common\validators\MasterScheduleValidator;
use common\validators\SalonExistValidator;
use common\behaviors\AccountBehavior;
use common\queries\MasterScheduleQuery;

/**
 * Class MasterSchedule
 *
 * @package common\models
 */
class MasterSchedule extends ActiveRecord
{
    const TYPE_WORKING = 1;

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
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%master_schedule}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['account_id', 'master_id', 'salon_id', 'type', 'start_date', 'end_date'], 'required'],
            [['account_id', 'master_id', 'salon_id', 'type'], 'integer'],
            [['start_date', 'end_date'], 'date', 'format' => 'php:Y-m-d H:i:s'],
            ['type', 'in', 'range' => array_keys(self::getTypeList())],
            ['salon_id', SalonExistValidator::class],
            ['master_id', MasterExistValidator::class],
            ['item', MasterScheduleValidator::class, 'on' => self::SCENARIO_DEFAULT],
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
            AccountBehavior::class
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


    public static function find()
    {
        return new MasterScheduleQuery(get_called_class());
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
    public static function deleteOneById(int $id)
    {
        return self::deleteAll([
            'id' => $id,
            'account_id' => Yii::$app->account->getId()
        ]);
    }
}
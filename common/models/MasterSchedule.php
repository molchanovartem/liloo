<?php

namespace common\models;

use yii\db\ActiveRecord;
use common\queries\Query;

/**
 * Class MasterSchedule
 *
 * @package common\models
 */
class MasterSchedule extends ActiveRecord
{
    const TYPE_WORKING = 1;

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
    public static function getTypeList(): array
    {
        return [
            self::TYPE_WORKING => 'working'
        ];
    }


    public static function find()
    {
        return new Query(get_called_class());
    }
}
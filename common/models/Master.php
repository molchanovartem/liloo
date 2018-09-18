<?php

namespace common\models;

use yii\db\ActiveRecord;
use common\queries\Query;

/**
 * Class Master
 *
 * @package common\models
 */
class Master extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%master}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['account_id', 'name'], 'required'],
            [['account_id', 'user_id'], 'integer'],
            [['surname', 'name', 'patronymic'], 'string', 'max' => 255],
            ['date_birth', 'date', 'format' => 'php:Y-m-d']
        ];
    }

    /**
     * @return Query|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new Query(get_called_class());
    }
}
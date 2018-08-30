<?php

namespace common\models;

use common\queries\Query;
use yii\db\ActiveRecord;

/**
 * Class Country
 *
 * @package common\models
 */
class Country extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%country}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['name', 'currency_code', 'currency_string_code', 'phone_code'], 'required'],
            [['currency_code', 'phone_code'], 'integer'],
            [['currency_code', 'currency_string_code'], 'string', 'max' => 3],
            ['name', 'string', 'max' => 255]
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
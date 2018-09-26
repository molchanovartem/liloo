<?php
namespace common\models;

use yii\db\ActiveRecord;
use common\queries\Query;
use common\validators\CountryExistValidator;

/**
 * Class City
 *
 * @package common\models
 */
class City extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%city}}';
    }

    public function rules()
    {
        return [
            [['country_id', 'name', 'phone_code'], 'required'],
            [['country_id', 'phone_code'], 'integer'],
            ['name', 'string', 'max' => 255],
            [['latitude', 'longitude'], 'number'],
            ['country_id', CountryExistValidator::class] // ???
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
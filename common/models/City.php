<?php
namespace common\models;

use common\queries\CityQuery;
use common\validators\CountryExistValidator;
use yii\db\ActiveRecord;

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
            ['country_id', CountryExistValidator::class]
        ];
    }

    /**
     * @return CityQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new CityQuery(get_called_class());
    }
}
<?php

namespace common\models;

use common\queries\ServiceQuery;
use Yii;
use common\queries\Query;

/**
 * Class Service
 *
 * @package common\models
 */
class Service extends \yii\db\ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%service}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        /*
         * @todo
         * duration проверка на количество символов
         */

        return [
            [['account_id', 'is_group', 'specialization_id', 'name'], 'required'],
            [['account_id', 'parent_id', 'duration', 'common_service_id', 'specialization_id'], 'integer'],
            [['price'], 'number'],
            [['price', 'duration'], 'number', 'min' => 0],
            ['price', 'string', 'max' => 15],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @return array
     */
    public static function modelAttributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'account_id' => Yii::t('app', 'Account'),
            'salon_id' => Yii::t('app', 'Salon'),
            'specialization_id' => Yii::t('app', 'Specialization'),
            'name' => Yii::t('app', 'Name'),
            'price' => Yii::t('app', 'Price'),
            'duration' => Yii::t('app', 'Duration'),
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return self::modelAttributeLabels();
    }

    public static function find()
    {
        return new ServiceQuery(get_called_class());
    }
}

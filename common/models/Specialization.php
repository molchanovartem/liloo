<?php

namespace common\models;

use Yii;
use common\queries\Query;

/**
 * Class Specialization
 * @package common\models
 */
class Specialization extends \yii\db\ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%specialization}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @return array
     */
    public static function modelAttributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return self::modelAttributeLabels();
    }

    /**
     * @return Query|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new Query(get_called_class());
    }

    /**
     * @param $accountId
     * @return mixed
     */
//    public function getServiceByAccount($accountId)
//    {
//        return Service::find()->bySpecializationId($this->id)->andWhere(['account_id' => $accountId])->all();
//    }

    /**
     * @return mixed
     */
//    public function getMinPrice()
//    {
//        return Service::find()->bySpecializationId($this->id)->min('price');
//    }
}

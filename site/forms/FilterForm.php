<?php

namespace site\forms;

use common\models\City;
use yii\base\Model;
use common\models\Specialization;
use yii\helpers\ArrayHelper;

/**
 * Class FilterForm
 * @package site\forms
 */
class FilterForm extends Model
{
    public $specialization;
    public $city;
    public $date;
    public $time;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['specialization', 'city'], 'integer'],
            [['date'], 'date', 'format' => 'php:Y-m-d'],
            [['time'], 'date', 'format' => 'php:H:i:s'],
        ];
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getSpecialization()
    {
        $array = Specialization::find()->select('*')->asArray()->all();

        return ArrayHelper::map($array, 'id', 'name');
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getCities()
    {
        $array = City::find()
            ->select(['id as value', 'name as label'])
            ->asArray()
            ->all();

        return $array;
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'specialization' => 'Выбор специализации мастера',
            'city' => 'Выбор города',
            'date' => 'Выбор даты',
            'time' => 'Выбор времени',
        ];
    }
}

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
            [['city'], 'required'],
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

    /**
     * @return string
     */
    public function formName()
    {
        return '';
    }

    /**
     * @return array
     */
    public function getCities()
    {
        $array = City::find()->select('*')->asArray()->all();

        return ArrayHelper::map($array, 'id', 'name');
    }

    public function getTime()
    {
        return [
            '0.0' => '0:00',
            '0.25' => '0:15',
            '0.5' => '0:30',
            '0.75' => '0:45',
        ];
    }
}

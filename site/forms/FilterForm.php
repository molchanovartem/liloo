<?php

namespace site\forms;

use common\models\City;
use yii\base\Model;
use common\models\Specialization;

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
            [['start_date', 'date'], 'date', 'format' => 'php:Y-m-d'],
            [['start_date', 'time'], 'date', 'format' => 'php:H:i:s'],
        ];
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getSpecialization()
    {
        return Specialization::find()->select('*')->asArray()->all();
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getCities()
    {
        return City::find()->select('name')->asArray()->all();
    }
}

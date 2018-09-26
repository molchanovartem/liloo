<?php

namespace site\forms;

use common\models\Appointment;
use common\models\City;
use common\models\CommonService;
use common\models\MasterSchedule;
use common\models\UserSchedule;
use yii\base\Model;
use common\models\Specialization;
use yii\helpers\ArrayHelper;

/**
 * Class FilterForm
 * @package site\forms
 */
class FilterForm extends Model
{
    public $service;
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
            [['city', 'service', 'specialization'], 'integer'],
            [['date'], 'date', 'format' => 'php:Y-m-d'],
            ['time', 'each', 'rule' => ['string']],
        ];
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getSpecialization()
    {
        $array = Specialization::find()
            ->asArray()
            ->all();

        return ArrayHelper::map($array, 'id', 'name');
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getServices()
    {
        return CommonService::find()
            ->asArray()
            ->all();
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'service' => 'Выбор услуги',
            'specialization' => 'Выбор специализыции',
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

    /**
     * @return mixed
     */
    public static function getPartTime()
    {
        date_default_timezone_set('UTC');
        $num = 86400 / 900;

        for ($i = 1; $i <= $num; $i++) {
            $mktime = $i * 900;
            $time = date("H:i", $mktime);
            $partTime[$time] = $time;
        }

        return $partTime;
    }
}

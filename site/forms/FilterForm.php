<?php

namespace site\forms;

use common\models\Appointment;
use common\models\City;
use common\models\CommonService;
use common\models\Service;
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
            [['time'], 'date', 'format' => 'php:H:i:s'],
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

    public function getTime()
    {
        return [
            '0.0' => '0:00',
            '0.25' => '0:15',
            '0.5' => '0:30',
            '0.75' => '0:45',
        ];
    }

    /**
     * @param $userId
     * @return array
     */
    public function getCurrentTime($userId)
    {
        $userSchedules = UserSchedule::find()->select('start_date, end_date')->where(['user_id' => $userId])->all();
        $userAppointments = Appointment::find()->select('start_date, end_date')->where(['user_id' => $userId])->all();
        $appointmentTime = [];
        $time = [];

        foreach ($this->getPartTime() as $item) {
            foreach ($userSchedules as $userSchedule) {
                $currentDay = date_format(date_create($userSchedule->start_date), 'Y-m-d');

                if ($userSchedule->start_date < $currentDay . ' ' . $item && $userSchedule->end_date > $currentDay . ' ' . $item) {
                    $time[] = $item;
                }
            }
        }

        foreach ($time as $k => $t) {
            foreach ($userAppointments as $userAppointment) {
                if ($userAppointment->start_date <= $currentDay . ' ' . $t && $userAppointment->end_date >= $currentDay . ' ' . $t) {
                    $appointmentTime[] = $t;
                }
            }
        }

        return array_diff($time, $appointmentTime);
    }

    /**
     * @return mixed
     */
    public function getPartTime()
    {
        date_default_timezone_set('UTC');
        $num = 86400 / 900;

        for ($i = 1; $i <= $num; $i++) {
            $mktime = $i * 900;
            $date = date("H:i:s", $mktime);
            $datesMonth[$i] = $date;
        }

        return $datesMonth;
    }
}

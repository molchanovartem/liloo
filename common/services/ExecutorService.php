<?php

namespace common\services;

use common\core\service\ModelService;
use common\models\Appointment;
use common\models\MasterSchedule;
use common\models\Service;
use common\models\UserSchedule;
use GraphQL\Error\Error;
use site\forms\FilterForm;

/**
 * Class ExecutorService
 * @package common\services
 */
class ExecutorService extends ModelService
{
    /**
     * @param int $userId
     * @param $currentDate
     * @return array
     */
    public function getCurrentTime(int $userId, $currentDate)
    {
        $userSchedules = UserSchedule::find()->select('start_date, end_date')->where(['user_id' => $userId])->all();
        $userAppointments = Appointment::find()->select('start_date, end_date')->where(['user_id' => $userId])->all();
        $appointmentTime = [];
        $times = [];

        foreach (FilterForm::getPartTime() as $partTime) {
            foreach ($userSchedules as $userSchedule) {
                if ($userSchedule->start_date <= $currentDate . ' ' . $partTime . ':00' && $userSchedule->end_date > $currentDate . ' ' . $partTime . ':00') {
                    $times[] = $partTime;
                }
            }
        }

        foreach ($times as $time) {
            foreach ($userAppointments as $userAppointment) {
                if ($userAppointment->start_date <= $currentDate . ' ' . $time . ':00' && $userAppointment->end_date > $currentDate . ' ' . $time . ':00') {
                    $appointmentTime[] = $time;
                }
            }
        }

        return array_diff($times, $appointmentTime);
    }


    /**
     * @param null $times
     * @param $userId
     * @param $currentDate
     * @return array
     */
    public function getValidTime($times = null, $userId, $currentDate)
    {
        if ($times == null) {
            return $this->getCurrentTime($userId, $currentDate);
        }

        return array_intersect($times, $this->getCurrentTime($userId, $currentDate));
    }

    /**
     * @param $salonId
     * @param $currentDate
     * @return array
     */
    public function getCurrentTimeSalon($salonId, $currentDate)
    {
        $masterSchedules = MasterSchedule::find()->select('master_id, start_date, end_date')->where(['salon_id' => $salonId])->all();
        $masterAppointments = Appointment::find()->select('master_id, start_date, end_date')->where(['salon_id' => $salonId])->all();

        $appointmentTime = [];
        $time = [];
        $currentTime = [];

        foreach (FilterForm::getPartTime() as $partTime) {
            foreach ($masterSchedules as $masterSchedule) {
                if ($masterSchedule->start_date < $currentDate . ' ' . $partTime . ':00' && $masterSchedule->end_date > $currentDate . ' ' . $partTime . ':00') {
                    $time[] = $partTime . '->' . $masterSchedule->master_id;
                }
            }
        }

        foreach (FilterForm::getPartTime() as $partTime) {
            foreach ($masterAppointments as $masterAppointment) {
                if ($masterAppointment->start_date < $currentDate . ' ' . $partTime . ':00' && $masterAppointment->end_date > $currentDate . ' ' . $partTime . ':00') {
                    $appointmentTime[] = $partTime . '->' . $masterAppointment->master_id;
                }
            }
        }

        foreach (array_diff($time, $appointmentTime) as $item) {
            $currentTime[] = explode('->', $item)[0];
        }

        return array_unique($currentTime);
    }

    /**
     * @param $masterId
     * @param $currentDate
     * @return array
     */
    public function getCurrentTimeSalonMaster($masterId, $currentDate)
    {
        $userSchedules = MasterSchedule::find()->select('start_date, end_date')->where(['master_id' => $masterId])->all();
        $userAppointments = Appointment::find()->select('start_date, end_date')->where(['master_id' => $masterId])->all();
        $appointmentTime = [];
        $times = [];

        foreach (FilterForm::getPartTime() as $partTime) {
            foreach ($userSchedules as $userSchedule) {
                if ($userSchedule->start_date < $currentDate . ' ' . $partTime . ':00' && $userSchedule->end_date > $currentDate . ' ' . $partTime . ':00') {
                    $times[] = $partTime;
                }
            }
        }

        foreach ($times as $time) {
            foreach ($userAppointments as $userAppointment) {
                if ($userAppointment->start_date <= $currentDate . ' ' . $time . ':00' && $userAppointment->end_date >= $currentDate . ' ' . $time . ':00') {
                    $appointmentTime[] = $time;
                }
            }
        }

        return array_diff($times, $appointmentTime);
    }

    /**
     * @param null $times
     * @param $salonId
     * @param $currentDate
     * @return array
     */
    public function getValidTimeSalon($times = null, $salonId, $currentDate)
    {
        if ($times == null) {
            return $this->getCurrentTimeSalon($salonId, $currentDate);
        }

        return array_intersect($times, $this->getCurrentTimeSalon($salonId, $currentDate));
    }

    /**
     * @param array $serviceIds
     * @return mixed
     */
    public function getServiceSumTime(array $serviceIds)
    {
        return Service::find()->where(['in', 'id', $serviceIds])->sum('duration');
    }

    /**
     * @param array $serviceIds
     * @return mixed
     */
    public function getServiceSumPrice(array $serviceIds)
    {
        return Service::find()->where(['in', 'id', $serviceIds])->sum('price');
    }

    /**
     * @param array $time
     * @param       $userAppointments
     * @param       $workTime
     * @param       $date
     * @param       $schedule
     *
     * @return array
     */
    public function getFreePartTime(array $time, $userAppointments, $workTime, $date, $schedule)
    {
        $error = [];
        $j = $time[0];
        $schedule = array_pop($schedule);

        foreach ($userAppointments as $userAppointment) {
            foreach ($time as $t) {
                $endSession = $this->sumTime($t, $workTime);
                while ($j != $endSession) {
                    if (
                        $userAppointment->start_date <= $date . ' ' . $j . ':00'
                        && $userAppointment->end_date >= $date . ' ' . $j . ':00'
                    ) {
                        $error[] = $j;
                    }

                    $j = $this->sumTime($j, '00:15');
                }

                if ($schedule['end_date'] < $date . ' ' . $endSession . ':00') {
                    $error[] = $t;
                }
            }
        }

        return array_diff($time, $error);
    }

    /**
     * @param $i
     * @param $k
     * @return false|string
     */
    private function sumTime($i, $k)
    {
        return date('H:i', strtotime($i) + strtotime($k) - strtotime("00:00:00"));
    }
}

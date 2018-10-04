<?php

namespace api\services\site;

use api\services\Service;
use common\helpers\FreeDateTime;
use common\models\Appointment;
use common\models\MasterSchedule;
use common\models\Service as ServiceModel;
use common\models\UserSchedule;

/**
 * Class ExecutorService
 * @package common\services
 */
class ExecutorService extends Service
{
    /**
     * @param array $serviceIds
     * @return float|int
     */
    public function getServiceSumTimeInSecond(array $serviceIds)
    {
        return ServiceModel::find()->where(['in', 'id', $serviceIds])->sum('duration') * 60;
    }

    /**
     * @param bool $isSalon
     * @param int $executorId
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getAppointment(bool $isSalon, int $executorId)
    {
        return $isSalon ?
            Appointment::find()
                ->select(['start_date', 'end_date'])
                ->where(['master_id' => $executorId])
                ->all() :
            Appointment::find()
                ->select(['start_date', 'end_date'])
                ->where(['user_id' => $executorId])
                ->all();
    }

    /**
     * @param bool $isSalon
     * @param int $executorId
     * @param $date
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getSchedule(bool $isSalon, int $executorId, $date)
    {
        return $isSalon ?
            MasterSchedule::find()
                ->where(['master_id' => $executorId])
                ->andWhere(['date(end_date)' => $date])
                ->orderBy('end_date')
                ->asArray()
                ->all() :
            UserSchedule::find()
                ->where(['user_id' => $executorId])
                ->andWhere(['date(end_date)' => $date])
                ->orderBy('end_date')
                ->asArray()
                ->all();
    }

    /**
     * @param $isSalon
     * @param $executorId
     * @param $date
     * @return array
     */
    public function getFreeTime($isSalon, $executorId, $date, $serviceTime = null)
    {
        $appointments = $this->getAppointment($isSalon, $executorId);
        $schedule = $this->getSchedule($isSalon, $executorId, $date);
        $freeTime = new FreeDateTime($schedule, $appointments);
        $partTime = [];

        foreach ($freeTime->getFreeTimes() as $time) {
            $partTime[] = $time;
        }

        return $partTime;
    }

    public function getFreeWithServiceTime($isSalon, $executorId, $date, $serviceTime = null)
    {
        $appointments = $this->getAppointment($isSalon, $executorId);
        $schedule = $this->getSchedule($isSalon, $executorId, $date);
        $freeTime = new FreeDateTime($schedule, $appointments);
        $partTime = [];

        foreach ($freeTime->getFilterFreeTime($serviceTime) as $time) {
            $partTime[] = $time;
        }

        return $partTime;
    }
}

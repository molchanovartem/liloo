<?php

namespace api\graphql\common\services;

use yii\db\Expression;
use common\models\MasterSchedule;
use common\models\UserSchedule;
use common\helpers\FreeDateTime;
use common\models\Appointment;
use api\services\Service;

/**
 * Class FreeTimeService
 *
 * @package api\graphql\common\services
 */
class FreeTimeService extends Service
{
    /**
     * @param int $userId
     * @param string $date
     * @param int $period
     * @param null $unaccountedTime
     * @return array
     * @throws \Exception
     */
    public function getUserFreeTime(int $userId, string $date, $period = 30, $unaccountedTime = null): array
    {
        $appointments = $this->getAppointments('user_id', $userId, $date);

        $schedule = UserSchedule::find()
            ->where(['user_id' => $userId])
            ->andWhere(new Expression('DATE(`start_date`) = DATE(:date)', ['date' => $date]))
            ->asArray()
            ->all();

        $periods = [];
        if (!empty($schedule)) {
            $freeTime = new FreeDateTime($schedule, $appointments);

            foreach ($freeTime->getPeriods($period, $unaccountedTime, true) as $period) {
                if (strtotime($period) > strtotime($date)) {
                    $periods[] = $period;
                }
            }
        }

        return $periods;
    }

    /**
     * @param int $masterId
     * @param string $date
     * @param int $period
     * @param null $unaccountedTime
     * @return array
     * @throws \Exception
     */
    public function getMasterFreeTime(int $masterId, string $date, $period = 30, $unaccountedTime = null): array
    {
        $appointments = $this->getAppointments('master_id', $masterId, $date);

        $schedule = MasterSchedule::find()
            ->where(['master_id' => $masterId])
            ->andWhere(new Expression('DATE(`start_date`) = DATE(:date)', ['date' => $date]))
            ->asArray()
            ->all();

        $periods = [];
        if (!empty($schedule)) {
            $freeTime = new FreeDateTime($schedule, $appointments);

            foreach ($freeTime->getPeriods($period, $unaccountedTime, true) as $period) {
                if (strtotime($period) > strtotime($date)) {
                    $periods[] = $period;
                }
            }
        }

        return $periods;
    }

    /**
     * @param string $by
     * @param int $byId
     * @param string $date
     * @return array
     */
    private function getAppointments(string $by, int $byId, string $date): array
    {
        return $appointments = Appointment::find()
            ->where([$by => $byId])
            ->andWhere(new Expression('DATE(`start_date`) = DATE(:date)', ['date' => $date]))
            ->orderBy(['start_date' => SORT_ASC])
            ->asArray()
            ->all();
    }
}
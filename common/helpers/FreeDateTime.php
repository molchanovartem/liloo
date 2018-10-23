<?php

namespace common\helpers;

use yii\helpers\ArrayHelper;

/**
 * Class FreeDateTime
 *
 * @package common\helpers
 */
class FreeDateTime
{
    /**
     * @var array
     */
    private $schedules = [];

    /**
     * @var array
     */
    private $appointments = [];

    /**
     * FreeDateTime constructor.
     *
     * @param array $schedules
     * @param array $appointments
     */
    public function __construct(array $schedules, array $appointments)
    {
        $this->schedules = $schedules;
        $this->appointments = $appointments;

        ArrayHelper::multisort($this->schedules, 'start_date');
        ArrayHelper::multisort($this->appointments, 'start_date');
    }

    /**
     * @return \Generator
     */
    public function getFreeTimes(): \Generator
    {
        foreach ($this->schedules as $schedule) {
            $scheduleStart = strtotime($schedule['start_date']);
            $scheduleEnd = strtotime($schedule['end_date']);
            $start = $scheduleStart;
            $end = null;

            $appointments = $this->getAppointmentsRangeDateTime($schedule['start_date'], $schedule['end_date']);

            while (true) {
                if ($scheduleEnd === $end) break;

                $end = $scheduleEnd;
                $appCurr = $appointments->current();
                $appointments->next();

                if ($appCurr) {
                    $end = strtotime($appCurr['start_date']);

                    if ($scheduleStart === strtotime($appCurr['start_date'])) {
                        $start = strtotime($appCurr['end_date']);
                        continue;
                    }
                }

                if ($start === $end) break;

                yield [
                    'start_time' => date('Y-m-d H:i:s', $start + 60), // +60 секунд перерыв
                    'end_time' => date('Y-m-d H:i:s', $end),
                ];

                if ($appCurr) $start = strtotime($appCurr['end_date']);
            }
        }
    }

    /**
     * @param $startDate
     * @param $endDate
     * @return \Generator
     */
    private function getAppointmentsRangeDateTime($startDate, $endDate): \Generator
    {
        foreach ($this->appointments as $appointment) {
            if (strtotime($appointment['start_date']) >= strtotime($startDate) &&
                strtotime($appointment['end_date']) <= strtotime($endDate)) {
                yield $appointment;
            }
        }
        yield;
    }

    /**
     * @param int $minute
     * @param null $unaccountedTime
     * @param bool $roundByMinute
     * @return \Generator
     * @throws \Exception
     */
    public function getPeriods(int $minute, $unaccountedTime = null, $roundByMinute = false): \Generator
    {
        foreach ($this->getFreeTimes() as $dateTime) {
            $begin = new \DateTime($dateTime['start_time']);
            $end = new \DateTime($dateTime['end_time']);

            if ($unaccountedTime) {
                $end = new \DateTime();
                $end->setTimestamp(strtotime($dateTime['end_time']) - $unaccountedTime);
            }

            if ($roundByMinute) {
                $begin->setTime($begin->format('H'), ceil($begin->format('i') / 10) * 10);
            }

            $interval = new \DateInterval(sprintf('PT%uM', $minute));
            $daterange = new \DatePeriod($begin, $interval, $end);

            foreach ($daterange as $dt) {
                yield $dt->format("Y-m-d H:i:s");
            }
        }
    }

    /**
     * @param $dateTime
     *
     * @return bool
     */
    public function existTime($dateTime): bool
    {
        $dateTime = strtotime($dateTime);

        foreach ($this->getFreeTimes() as $freeDateTime) {
            $startTime = strtotime($freeDateTime['start_time']);
            $endTime = strtotime($freeDateTime['end_time']);

            if ($startTime <= $dateTime && $endTime >= $dateTime) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param array $freeTime
     * @param int $second
     * @return bool
     */
    private function hasPeriodTime(array $freeTime, int $second): bool
    {
        return (strtotime($freeTime['end_time']) - strtotime($freeTime['start_time'])) >= $second;
    }

    /**
     * @param int $totalSecond
     * @return \Generator
     */
    public function getFilterFreeTime(int $totalSecond): \Generator
    {
        foreach ($this->getFreeTimes() as $freeDateTime) {
            if ($this->hasPeriodTime($freeDateTime, $totalSecond)) yield $freeDateTime;
        }
    }
}
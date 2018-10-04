<?php

namespace common\helpers;

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
    }

    /**
     * @return \Generator
     */
    public function getFreeTimes(): \Generator
    {
        $appointments = $this->appointments;
        $count = count($appointments);

        // черт ногу сломит, расписать логику
        foreach ($this->schedules as $schedule) {
            $scheduleStart = strtotime($schedule['start_date']);
            $scheduleEnd = strtotime($schedule['end_date']);

            $i = 0;
            reset($appointments);

            while (true) {
                $i++;

                if ($count === 0) {
                    yield [
                        'start_time' => date('Y-m-d H:i:s', $scheduleStart),
                        'end_time' => date('Y-m-d H:i:s', $scheduleEnd),
                    ];

                    break;
                } else if ($i > $count) {
                    $start = strtotime($appointments[$count - 1]['end_date']);
                    $end = $scheduleEnd;

                    yield [
                        'start_time' => date('Y-m-d H:i:s', $start),
                        'end_time' => date('Y-m-d H:i:s', $end),
                    ];
                    break;
                }

                $key = key($appointments);
                $appointment = $appointments[$key];
                $appointmentStart = strtotime($appointment['start_date']);
                $appointmentEnd = strtotime($appointment['end_date']);

                $prevAppointment = $appointments[$key - 1] ?? null;
                $prevAppointmentEnd = $prevAppointment ? strtotime($prevAppointment['end_date']) : null;

                $nextAppointment = $appointments[$key + 1] ?? null;
                $nextAppointmentStart = $nextAppointment ? strtotime($nextAppointment['start_date']) : null;

                if ($appointmentStart >= $scheduleStart) {
                    if ($appointmentStart > $scheduleStart) {
                        $start = ($key == 0) ? $scheduleStart : ($prevAppointmentEnd < $scheduleStart ? $scheduleStart : $prevAppointmentEnd);
                        $end = ($key == 0 || $appointmentStart < $scheduleEnd) ? $appointmentStart : $scheduleEnd;
                    } else {
                        if ($appointmentStart == $scheduleStart) {
                            if ($appointmentEnd > $scheduleEnd) continue;

                            $start = $appointmentEnd;
                            $end = ($nextAppointment === null || $nextAppointmentStart > $scheduleEnd) ? $scheduleEnd : $nextAppointmentStart;
                        }
                    }

                    yield [
                        'start_time' => date('Y-m-d H:i:s', $start),
                        'end_time' => date('Y-m-d H:i:s', $end),
                    ];

                    if ($end == $scheduleEnd) break;
                }
                next($appointments);
            }
        }
    }

    /**
     * @param int $minute
     * @param null $unaccountedTime
     * @return \Generator
     * @throws \Exception
     */
    public function getPeriods(int $minute, $unaccountedTime = null): \Generator
    {
        foreach ($this->getFreeTimes() as $dateTime) {
            $begin = new \DateTime($dateTime['start_time']);
            $end = new \DateTime($dateTime['end_time']);

            if ($unaccountedTime) {
                $end = new \DateTime();
                $end->setTimestamp(strtotime($dateTime['end_time']) - $unaccountedTime);
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
     * @param int $second
     * @return \Generator
     */
    public function getFilterFreeTime(int $second): \Generator
    {
        foreach ($this->getFreeTimes() as $freeDateTime) {
            if ($this->hasPeriodTime($freeDateTime, $second)) yield $freeDateTime;
        }
    }
}

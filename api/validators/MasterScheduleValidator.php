<?php

namespace api\validators;

use DateTime;
use api\models\lk\MasterSchedule;

/**
 * Class MasterScheduleValidator
 *
 * @package api\validators
 */
class MasterScheduleValidator extends BaseScheduleValidator
{
    /**
     * @param array $items
     * @return array
     */
    public function getBadDate(array $items)
    {
        $dates = [];
        $masters = [];
        $salons = [];
        foreach ($items as $item) {
            $date = new DateTime($item['start_date']);
            $dates[] = $date->format('Y-m-d');
            $masters[] = $item['master_id'];
            $salons[] = $item['salon_id'];
        }

        $masterSchedulesCurrentDates = MasterSchedule::find()
            ->where(['in', 'date(start_date)', $dates])
            ->andWhere(['in', 'master_id', array_unique($masters)])
            ->andWhere(['in', 'salon_id', array_unique($salons)])
            ->indexBy('id')
            ->asArray()
            ->allByCurrentAccountId();

        $badKeys = [];
        foreach ($items as $key => $item) {
            foreach ($masterSchedulesCurrentDates as $id => $masterSchedulesCurrentDate) {
                if (!empty($item['id']) && ($item['id'] == $masterSchedulesCurrentDate['id'])) continue;

                if ((
                    (date($item['start_date']) >= date($masterSchedulesCurrentDate['start_date']) &&
                        date($item['start_date']) <= date($masterSchedulesCurrentDate['end_date'])) ||

                    (date($item['end_date']) >= date($masterSchedulesCurrentDate['start_date']) &&
                        date($item['end_date']) <= date($masterSchedulesCurrentDate['end_date'])) ||

                    (date($item['start_date']) <= date($masterSchedulesCurrentDate['start_date']) &&
                        (date($item['end_date']) >= date($masterSchedulesCurrentDate['end_date']))) &&

                    ($item['master_id'] == $masterSchedulesCurrentDate['master_id']) &&
                    ($item['salon_id'] == $masterSchedulesCurrentDate['salon_id'])
                )) {
                    $badKeys[$id] = $item;
                }
            }
        }
        return $badKeys;
    }
}
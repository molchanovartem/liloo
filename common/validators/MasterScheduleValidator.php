<?php

namespace common\validators;

use DateTime;
use common\models\MasterSchedule;

/**
 * Class MasterScheduleExistValidator
 *
 * @package common\validators
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
        foreach ($items as $item) {
            $date = new DateTime($item['start_date']);
            $dates[] = $date->format('Y-m-d');
            $masters[] = $item['master_id'];
        }

        $masterSchedulesCurrentDates = MasterSchedule::find()
            ->where(['in', 'date(start_date)', $dates])
            ->andWhere(['in', 'master_id', array_unique($masters)])
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
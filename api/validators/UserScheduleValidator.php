<?php

namespace api\validators;

use DateTime;
use api\models\UserSchedule;

/**
 * Class UserScheduleValidator
 *
 * @package api\validators
 */
class UserScheduleValidator extends BaseScheduleValidator
{
    /**
     * @param array $items
     * @return array
     */
    public function getBadDate(array $items)
    {
        $dates = [];
        $users = [];
        foreach ($items as $item) {
            $date = new DateTime($item['start_date']);
            $dates[] = $date->format('Y-m-d');
            $users[] = $item['user_id'];
        }

        $userSchedulesCurrentDates = UserSchedule::find()
            ->where(['in', 'date(start_date)', $dates])
            ->andWhere(['in', 'user_id', array_unique($users)])
            ->indexBy('id')
            ->asArray()
            ->all();

        $badKeys = [];
        foreach ($items as $key => $item) {
            foreach ($userSchedulesCurrentDates as $id => $userSchedulesCurrentDate) {
                if (!empty($item['id']) && ($item['id'] == $userSchedulesCurrentDate['id'])) continue;

                if ((
                    (date($item['start_date']) >= date($userSchedulesCurrentDate['start_date']) &&
                        date($item['start_date']) <= date($userSchedulesCurrentDate['end_date'])) ||

                    (date($item['end_date']) >= date($userSchedulesCurrentDate['start_date']) &&
                        date($item['end_date']) <= date($userSchedulesCurrentDate['end_date'])) ||

                    (date($item['start_date']) <= date($userSchedulesCurrentDate['start_date']) &&
                        (date($item['end_date']) >= date($userSchedulesCurrentDate['end_date']))) &&

                    $item['user_id'] == $userSchedulesCurrentDate['user_id']
                )) {
                    $badKeys[$id] = $item;
                }
            }
        }
        return $badKeys;
    }
}
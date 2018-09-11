<?php

namespace common\validators;

use DateTime;
use Yii;
use yii\validators\Validator;
use common\models\MasterSchedule;

/**
 * Class MasterScheduleExistValidator
 *
 * @package common\validators
 */
class MasterScheduleExistValidator extends Validator
{
    /**
     * @var string
     */
    public $message = '{value}';

    /**
     * @param mixed $value
     * @param null $error
     * @return bool
     */
    public function validate($value, &$error = null)
    {
        if (!$result = $this->validateValue($value)) return true;

        list($message, $params) = $result;
        $params['attribute'] = Yii::t('yii', 'the input value');

        $error = $this->formatMessage($message, $params);

        return false;
    }

    /**
     * @param mixed $items
     * @return array|null
     */
    protected function validateValue($items)
    {
        if (!$badKeys = $this->getBadDate($items)) return null;

        return [$this->message, [
            'value' => json_encode($badKeys),
        ]];
    }

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
            ->all();

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
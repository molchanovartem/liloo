<?php

namespace common\validators;


use common\models\MasterSchedule;
use DateTime;
use Yii;
use yii\validators\Validator;

class MasterScheduleExistValidator extends Validator
{
    /**
     * @var string
     */
    /*
     * @todo
     * Подкорректировать текст
     */
    public $message = '{attribute} нет салона {value}';

    public function validate($value, &$error = null)
    {
        if (!$result = $this->validateValue($value)) {
            return true;
        }

        list($message, $params) = $result;
        $params['attribute'] = Yii::t('yii', 'the input value');

        $error = $this->formatMessage($message, $params);

        return false;
    }

    protected function validateValue($items)
    {
        $dates = [];
        $masters = [];
//        $items = (array)$items;
//
//        foreach ($items as $key => $item) {
//            return [$this->message, [
//                'value' => $item['master_id'],
//            ]];
//        }

        foreach ($items as $key => $item) {
            $date = new DateTime($item);
            $dates[] = $date->format('Y-m-d');
            $masters[] = $item['master_id'];
        }

        $masterSchedulesCurrentDates = MasterSchedule::find()
            ->where(['in', 'date(start_date)', $dates])
            ->where(['in', 'master_id', array_unique($masters)])
            ->all();

        foreach ($items as $key => $item) {
            foreach ($masterSchedulesCurrentDates as $masterSchedulesCurrentDate) {
                if (date($item['start_date']) >= date($masterSchedulesCurrentDate['start_date']) and
                    date($item['start_date']) <= date($masterSchedulesCurrentDate['end_date'])
                ) {
                    return [$this->message, [
                        'value' => 'Это время занято',
                    ]];
                }

                if (date($item['end_date']) >= date($masterSchedulesCurrentDate['start_date']) and
                    date($item['end_date']) <= date($masterSchedulesCurrentDate['end_date'])
                ) {
                    return [$this->message, [
                        'value' => 'Это время занято',
                    ]];
                }
            }
        }

        return null;
    }
}
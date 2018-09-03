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
    public $message = '{value}';

    public function validate($value, &$error = null)
    {
        if (!$result = $this->validateValue($value)) return true;

        list($message, $params) = $result;
        $params['attribute'] = Yii::t('yii', 'the input value');

        $error = $this->formatMessage($message, $params);

        return false;
    }

    protected function validateValue($items)
    {
        $dates = [];
        $masters = [];
        $badKeys = [];

        foreach ($items as $item) {
            $date = new DateTime($item['start_date']);
            $dates[] = $date->format('Y-m-d');
            $masters[] = $item['master_id'];
        }

        $masterSchedulesCurrentDates = MasterSchedule::find()
            ->where(['in', 'date(start_date)', $dates])
            ->where(['in', 'master_id', array_unique($masters)])
            ->all();

        foreach ($items as $item) {
            foreach ($masterSchedulesCurrentDates as $masterSchedulesCurrentDate) {
                if (date($item['start_date']) >= date($masterSchedulesCurrentDate['start_date']) and
                    date($item['start_date']) <= date($masterSchedulesCurrentDate['end_date']) and
                    date($item['end_date']) >= date($masterSchedulesCurrentDate['start_date']) and
                    date($item['end_date']) <= date($masterSchedulesCurrentDate['end_date'])
                ) {
                    $badKeys[] = $item;
                }
            }
        }
        $badKeys = array_intersect_key($badKeys, array_unique(array_map('serialize', $badKeys)));

        if (!empty($badKeys)) {
            return [$this->message, [
                'value' => json_encode($badKeys),
            ]];
        }

        return null;
    }
}
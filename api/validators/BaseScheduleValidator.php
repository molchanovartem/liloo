<?php

namespace api\validators;

use Yii;
use yii\validators\Validator;

/**
 * Class BaseScheduleValidator
 *
 * @package api\validators
 */
abstract class BaseScheduleValidator extends Validator
{
    /**
     * @param array $items
     * @return mixed
     */
    abstract public function getBadDate(array $items);

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
}
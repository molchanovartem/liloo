<?php

namespace api\validators;

use Yii;
use yii\validators\Validator;
use api\models\lk\Salon;

/**
 * Class SalonExistValidator
 *
 * @package api\validators
 */
class SalonExistValidator extends Validator
{
    /**
     * @var string
     */
    /*
     * @todo
     * Подкорректировать текст
     */
    public $message = '{attribute} нет салона {value}';

    /**
     * @param mixed $value
     * @param null $error
     * @return bool
     */
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

    /**
     * @param mixed $value
     * @return array|null
     */
    protected function validateValue($value)
    {
        $value = array_unique((array) $value);

        $services = Salon::find()
            ->select(['id'])
            ->asArray()
            ->byId($value)
            ->allByCurrentAccountId();

        $notExist = array_unique(array_diff($value, array_column($services, 'id')));

        if (count($notExist) === 0) return null;

        return [$this->message, [
            'value' => implode(', ', $notExist),
        ]];
    }
}
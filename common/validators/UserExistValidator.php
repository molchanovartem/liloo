<?php

namespace common\validators;

use Yii;
use yii\validators\Validator;
use common\models\User;

/**
 * Class UserExistValidator
 * @package common\validators
 */
class UserExistValidator extends Validator
{
    /**
     * @var string
     */
    public $message = '{attribute} нет пользователя {value}';

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
        $user = User::find()
            ->where(['id' => $value])
            ->one();

        if (!empty($user)) return null;

        return [$this->message, [
            'value' => $user,
        ]];
    }
}
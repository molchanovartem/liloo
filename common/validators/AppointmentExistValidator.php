<?php

namespace common\validators;

use common\models\Appointment;
use Yii;
use yii\validators\Validator;

/**
 * Class AppointmentExistValidator
 * @package common\validators
 */
class AppointmentExistValidator extends Validator
{
    /**
     * @var string
     */
    public $message = '{attribute} нет записи {appointment} c `client_id` {client}';

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
        $appointment = Appointment::find()
            ->leftJoin('lu_client', 'lu_client.id = lu_appointment.client_id')
            ->where(['lu_appointment.id' => $value])
            ->andWhere(['lu_client.user_id' => Yii::$app->user->getId()])
            ->one();

        if (!empty($appointment)) return null;

        return [$this->message, [
            'appointment' => $value,
            'client' => Yii::$app->user->getId(),
        ]];
    }
}
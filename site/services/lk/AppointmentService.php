<?php

namespace site\services\lk;

use common\core\service\ModelService;
use common\models\Appointment;
use site\models\User;

/**
 * Class AppointmentService
 *
 * @package site\services\lk
 */
class AppointmentService extends ModelService
{
    /**
     * @param $id
     *
     * @throws \Exception
     */
    protected function findUser($id)
    {
        if (($model = User::find()
                ->with(['clients'])
                ->with(['profile'])
                ->where(['id' => $id])
                ->one()) == null) throw new \Exception('Not find any user');

        $this->setData(['model' => $model]);
    }

    /**
     * @param int $id
     * @throws \Exception
     */
    public function getUserData(int $id)
    {
        $this->findUser($id);
        $user = $this->getData('model');
        $new = [];
        $canceled = [];

        foreach ($user->clients as $client) {
            foreach ($client->appointments as $appointment) {
                $new[] = $appointment->status == Appointment::STATUS_NEW ||
                         $appointment->status == Appointment::STATUS_CONFIRMED ? $appointment : null;
                $canceled[] = $appointment->status == Appointment::STATUS_COMPLETED ? $appointment : null;
            }
        }

        $appointments = [
            'new' => array_filter($new),
            'canceled' => array_filter($canceled),
        ];

        $this->setData(['appointments' => $appointments]);
    }
}

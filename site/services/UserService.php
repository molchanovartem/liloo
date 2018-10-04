<?php

namespace site\services;

use common\core\service\ModelService;
use common\models\Appointment;
use site\models\User;

/**
 * Class UserService
 * @package site\services
 */
class UserService extends ModelService
{
    /**
     * @param $id
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

    public function getUserData(int $id)
    {
        $this->findUser($id);
        $user = $this->getData('model');
        $new = [];
        $notConfirmed = [];
        $confirmed = [];
        $canceled = [];

        foreach ($user->clients as $client) {
            foreach ($client->appointments as $appointment) {
                $new[] = $appointment->status == Appointment::STATUS_NEW ? $appointment : null;
                $notConfirmed[] = $appointment->status == Appointment::STATUS_COMPLETED ? $appointment : null;
                $confirmed[] = $appointment->status == Appointment::STATUS_CONFIRMED ? $appointment : null;
                $canceled[] = $appointment->status == Appointment::STATUS_CANCELED ? $appointment : null;
            }
        }

        $appointments = [
            'new' => array_filter($new),
            'notConfirmed' => array_filter($notConfirmed),
            'confirmed' => array_filter($confirmed),
            'canceled' => array_filter($canceled),
        ];

        $this->setData(['appointments' => $appointments]);
    }
}

<?php

namespace site\services\lk;

use common\core\service\ModelService;
use common\models\Appointment;
use common\models\AppointmentItem;
use common\models\Recall;
use common\models\UserProfile;
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
                ->asArray()
                ->one()) == null) throw new \Exception('Not find any user');

        $this->setData(['model' => $model]);
    }

    /**
     * @param int $id
     * @throws \Exception
     */
//    public function getUserData(int $id)
//    {
//        $this->findUser($id);
//        $user = $this->getData('model');
//        $new = [];
//        $canceled = [];
//
//        foreach ($user->clients as $client) {
//            foreach ($client->appointments as $appointment) {
//                $new[] = $appointment->status == Appointment::STATUS_NEW ||
//                         $appointment->status == Appointment::STATUS_CONFIRMED ? $appointment : null;
//                $canceled[] = $appointment->status == Appointment::STATUS_COMPLETED ? $appointment : null;
//            }
//        }
//
//        $appointments = [
//            'new' => array_filter($new),
//            'canceled' => array_filter($canceled),
//        ];
//
//        $recall = new Recall();
//
//        $this->setData([
//            'appointments' => $appointments,
//            'recall' => $recall,
//            ]);
//    }

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

        foreach ($user['clients'] as $client) {
            foreach ($this->getAppointmentsByClientId($client['id']) as $appointment) {
                $new[] = $appointment['status'] == Appointment::STATUS_NEW ||
                         $appointment['status'] == Appointment::STATUS_CONFIRMED ? $appointment : null;
                $canceled[] = $appointment['status'] == Appointment::STATUS_COMPLETED ? $appointment : null;
            }
        }

        $appointments = [
            'new' => array_filter($new),
            'canceled' => array_filter($canceled),
        ];

        $recall = new Recall();

        $this->setData([
            'appointments' => $appointments,
            'recall' => $recall,
            ]);
    }

    protected function getAppointmentsByClientId($id)
    {
        return Appointment::find()
            ->with('userProfile')
            ->with('appointmentItems')
            ->where(['client_id' => $id])
            ->asArray()
            ->all();
    }
}

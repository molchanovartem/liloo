<?php

namespace site\services\lk;

use common\core\service\ModelService;
use common\models\Appointment;
use common\models\AppointmentItem;
use common\models\Client;
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
    public function getUserData(int $id)
    {
        $this->findUser($id);
        $user = $this->getData('model');
        $new = [];
        $canceled = [];

        foreach ($user['clients'] as $client) {
            foreach ($this->getAppointmentsByClientId($client['id']) as $appointment) {
                if ($appointment['status'] == Appointment::STATUS_NEW ||
                    $appointment['status'] == Appointment::STATUS_CONFIRMED) {
                    $new[] = $appointment;
                }

                if ($appointment['status'] == Appointment::STATUS_COMPLETED ) {
                    $canceled[] = $appointment;
                }
            }
        }

        $appointments = [
            'new' => $new,
            'canceled' => $canceled,
            'countNew' => count($new),
            'countCanceled' => count($canceled),
        ];

        $recall = new Recall();

        $this->setData([
            'appointments' => $appointments,
            'recall' => $recall,
            ]);
    }

    public function actionKek()
    {
        return Appointment::find()
            ->select('*')
            ->alias('app')
            ->leftJoin(Client::tableName() . ' cl', 'cl.id = app.client_id')
            ->leftJoin(User::tableName() . ' us', 'us.id = cl.user_id')
            ->where(['us.id' => \Yii::$app->user->getId()])


//            ->with('userProfile')
//            ->with('salon')
//            ->with('appointmentItems')
//            ->where(['client_id' => $id])
            ->asArray()
            ->all();
    }
}

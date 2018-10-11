<?php

namespace site\services\lk;

use common\core\service\ModelService;
use common\models\Appointment;
use common\models\Client;
use common\models\Recall;
use common\models\Salon;
use common\models\UserProfile;
use site\models\User;
use yii\data\ActiveDataProvider;

/**
 * Class AppointmentService
 *
 * @package site\services\lk
 */
class AppointmentService extends ModelService
{
    public function getUserData()
    {
        $new = [];
        $canceled = [];

        foreach ($this->getAppointments() as $appointment) {
            if ($appointment['status'] == Appointment::STATUS_NEW ||
                $appointment['status'] == Appointment::STATUS_CONFIRMED) {
                $new[] = $appointment;
            }

            if ($appointment['status'] == Appointment::STATUS_COMPLETED) {
                $canceled[] = $appointment;
            }
        }
        $appointments = [
            'new' => $new,
            'canceled' => $canceled,
            'countNew' => count($new),
            'countCanceled' => count($canceled),
        ];


//        $recall = new Recall();

        $this->setData([
            'appointments' => $appointments,
//            'recall' => $recall,
        ]);
    }


    public function getAppointments($isCanceled = false)
    {
        $query = Appointment::find()
            ->select('uspr.*, app.*, sal.name as salname')
            ->alias('app')
            ->leftJoin(Client::tableName() . ' cl', 'cl.id = app.client_id')
            ->leftJoin(User::tableName() . ' us', 'us.id = cl.user_id')
            ->leftJoin(UserProfile::tableName() . ' uspr', 'uspr.user_id = us.id')
            ->leftJoin(Salon::tableName() . ' sal', 'app.salon_id = sal.id')
            ->with('appointmentItems')
            ->where(['us.id' => \Yii::$app->user->getId()]);

            if ($isCanceled) {
                $query->andWhere(['app.status' => Appointment::STATUS_COMPLETED]);
            } else {
                $query->andWhere(['or', 'app.status = ' . Appointment::STATUS_NEW, 'app.status = ' . Appointment::STATUS_CONFIRMED]);
            }

        $provider = new ActiveDataProvider([
            'query' => $query->asArray(),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        $this->setData([
            'appointments' => $provider->getModels(),
            'total' => $provider->getTotalCount()
        ]);
    }
}

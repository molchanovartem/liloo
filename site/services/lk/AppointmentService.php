<?php

namespace site\services\lk;

use Yii;
use yii\base\Event;
use yii\data\ActiveDataProvider;
use common\core\service\ModelService;
use common\models\Appointment;
use common\models\Client;
use common\models\Notice;
use common\models\Recall;
use common\models\Salon;
use common\models\UserProfile;
use site\models\User;

/**
 * Class AppointmentService
 *
 * @package site\services\lk
 */
class AppointmentService extends ModelService
{
    const EVENT_USER_CANCELED_SESSION = 'canceled';

    public function init()
    {
        parent::init();
        $this->on(self::EVENT_USER_CANCELED_SESSION, function ($model) {
            Yii::$app->notice->createNotice($model->sender[0]->account_id, Notice::TYPE_USER_CANCELED_SESSION, Notice::STATUS_UNREAD, $model->sender[1], $model->sender[0]);
        });
    }

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

    /**
     * @param int $id
     * @param $reason
     * @return bool
     */
    public function cancelSession(int $id, $reason)
    {
        $appointment = Appointment::findOne($id);
        $appointment->status = Appointment::STATUS_CANCELED;
        $data = [$appointment, $reason];

        if ($appointment->save()) {
            $this->trigger(self::EVENT_USER_CANCELED_SESSION, new Event(['sender' => $data]));
            return true;
        }

        return false;
    }
}

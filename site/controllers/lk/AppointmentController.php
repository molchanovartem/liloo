<?php

namespace site\controllers\lk;

use common\models\Appointment;
use common\models\Client;
use common\models\User;
use common\models\UserProfile;
use site\services\lk\AppointmentService;

/**
 * Class AppointmentController
 *
 * @package site\controllers
 */
class AppointmentController extends Controller
{
    /**
     * AppointmentController constructor.
     *
     * @param string             $id
     * @param \yii\base\Module   $module
     * @param AppointmentService $appointmentService
     * @param array              $config
     */
    public function __construct(string $id, $module, AppointmentService $appointmentService, array $config = [])
    {
        $this->modelService = $appointmentService;

        parent::__construct($id, $module, $config);
    }

    /**
     * @param $id
     * @return string
     * @throws \Exception
     */
    public function actionView($id)
    {
        $this->modelService->getUserData($id);

        return $this->extraRender('/lk/appointment/view', ['data' => $this->modelService->getData()]);
    }

    /**
     * @param $id
     * @return bool
     */
    public function actionCancel($id)
    {
        $appointment = Appointment::findOne($id);
        $appointment->status = Appointment::STATUS_CANCELED;

        return $appointment->save() ? true : false;
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws \Exception
     */
    public function actionAppointmentData($id)
    {
        $this->modelService->getUserData($id);

        return $this->asJson($this->modelService->getData());
    }

    public function actionKek()
    {
        $kek = Appointment::find()
            ->select('*')
            ->alias('app')
            ->leftJoin(Client::tableName() . ' cl', 'cl.id = app.client_id')
            ->leftJoin(User::tableName() . ' us', 'us.id = cl.user_id')
            ->leftJoin(UserProfile::tableName() . ' up', 'up.user_id = us.id')
            ->where(['us.id' => \Yii::$app->user->getId()])


//            ->with('userProfile')
//            ->with('salon')
//            ->with('appointmentItems')
//            ->where(['client_id' => $id])
            ->asArray();

        var_dump($kek->createCommand()->rawSql);
    }
}

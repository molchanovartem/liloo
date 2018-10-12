<?php

namespace site\controllers\lk;

use common\models\Appointment;
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
     * @return array|string
     */
    public function actionView()
    {
        $this->modelService->getAppointments();

        return $this->extraRender('/lk/appointment/view', ['data' => $this->modelService->getData()]);
    }

    /**
     * @param $id
     * @return bool
     */
    public function actionCancel($id)
    {
        return $this->modelService->cancelSession($id);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionAppointmentDataNew()
    {
        $this->modelService->getAppointments();

        return $this->asJson($this->modelService->getData());
    }

    /**
     * @return \yii\web\Response
     */
    public function actionAppointmentDataCanceled()
    {
        $this->modelService->getAppointments(true);

        return $this->asJson($this->modelService->getData());
    }
}

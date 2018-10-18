<?php

namespace site\controllers;

use yii\filters\AccessControl;
use site\services\AppointmentService;

/**
 * Class AppointmentController
 *
 * @package site\controllers
 */
class AppointmentController extends Controller
{
    /**
     * @return array
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::class,
                'except' => ['create'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * AppointmentController constructor.
     *
     * @param string $id
     * @param $module
     * @param AppointmentService $appointmentService
     * @param array $config
     */
    public function __construct(string $id, $module, AppointmentService $appointmentService, array $config = [])
    {
        $this->modelService = $appointmentService;

        parent::__construct($id, $module, $config);
    }

    public function actionCreate()
    {
        return $this->extraRender('create');
    }

    /**
     * @return array|string
     */
    public function actionView()
    {
        $this->modelService->getAppointments();

        return $this->extraRender('/appointment/view', ['data' => $this->modelService->getData()]);
    }

    /**
     * @param $id
     * @param $reason
     * @return bool
     */
    public function actionCancel($id, $reason)
    {
        return $this->modelService->cancelSession($id, $reason);
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

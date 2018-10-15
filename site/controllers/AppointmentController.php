<?php

namespace site\controllers;

use site\services\AppointmentService;

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

    public function actionGetUserFreeTime($user_id, $date, $period = 30, $unaccounted_time = null)
    {
        return $this->asJson($this->modelService->getUserFreeTime($user_id, $date, $period, $unaccounted_time));
    }

    public function actionGetMasterFreeTime($master_id, $date, $period = 30, $unaccounted_time = null)
    {
        return $this->asJson($this->modelService->getUserFreeTime($master_id, $date, $period, $unaccounted_time));
    }
}
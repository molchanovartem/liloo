<?php

namespace site\controllers\lk;

use site\controllers\Controller;
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
}

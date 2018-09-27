<?php

namespace site\controllers;

use site\services\AppointmentService;

/**
 * Class AppointmentController
 * @package site\controllers
 */
class AppointmentController extends Controller
{
    /**
     * AppointmentController constructor.
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
        //$result = $this->modelService->save();
        //$data = $this->modelService->getData();

//        return $result ? $this->redirect(['view', 'id' => $data['model']->id]) :
//            $this->render('create', ['model' => $data['model']]);

        return $this->extraRender('create');
    }
}
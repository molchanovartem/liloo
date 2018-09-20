<?php

namespace site\controllers;

use site\services\ExecutorService;

/**
 * Class ExecutorController
 * @package site\controllers
 */
class ExecutorController extends Controller
{
    /**
     * ExecutorController constructor.
     * @param string $id
     * @param $module
     * @param ExecutorService $executorService
     * @param array $config
     */
    public function __construct(string $id, $module, ExecutorService $executorService, array $config = [])
    {
        $this->modelService = $executorService;

        parent::__construct($id, $module, $config);
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $this->modelService->index();
        $data = $this->modelService->getData();

        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('_listView', ['data' => $data]);
        }

        return $this->render('index', [
            'provider' => $data['provider'],
            'model' => $data['form']
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws \Exception
     */
    public function actionUserView($id)
    {
        $this->modelService->findUser($id);
        $data = $this->modelService->getData();

        return $this->render('userView', [
            'model' => $data['executor'],
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws \Exception
     */
    public function actionSalonView($id)
    {
        $this->modelService->findSalon($id);
        $data = $this->modelService->getData();

        return $this->render('salonView', [
            'model' => $data['executor'],
        ]);
    }
}
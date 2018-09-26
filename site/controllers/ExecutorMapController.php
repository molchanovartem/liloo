<?php

namespace site\controllers;

use Yii;
use site\services\ExecutorService;

/**
 * Class ExecutorMapController
 *
 * @package site\controllers
 */
class ExecutorMapController extends Controller
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

        if (Yii::$app->request->isAjax) return $this->asJson($data);

        return $this->render('index', ['data' => $data]);
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
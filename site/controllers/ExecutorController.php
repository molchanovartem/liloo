<?php

namespace site\controllers;

use site\forms\FilterForm;
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
        $this->modelService->getArrayProvider();
        $data = $this->modelService->getData();

        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('_listView');
        }

        $form = new FilterForm();

        return $this->render('index', [
            'provider' => $data['provider'],
            'model' => $form
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws \Exception
     */
    public function actionView($id)
    {
        $this->modelService->findExecutor($id);
        $data = $this->modelService->getData();

        return $this->render('view', [
            'model' => $data['executor'],
        ]);
    }
}
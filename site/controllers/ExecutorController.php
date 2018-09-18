<?php

namespace site\controllers;

use site\forms\FilterForm;
use site\services\ExecutorService;

class ExecutorController extends Controller
{
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
}
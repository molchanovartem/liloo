<?php

namespace admin\controllers;

use admin\models\Recall;
use admin\services\RecallService;

class RecallController extends Controller
{
    /**
     * NoticeController constructor.
     * @param string $id
     * @param $module
     * @param RecallService $recallService
     * @param array $config
     */
    public function __construct(string $id, $module, RecallService $recallService, array $config = [])
    {
        $this->modelService = $recallService;

        parent::__construct($id, $module, $config);
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $this->modelService->getAllRecalls();
        $data = $this->modelService->getData();

        return $this->render('index', [
            'recalls' => $data['recalls'],
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws \Exception
     */
    public function actionView($id)
    {
        $this->modelService->findRecall($id);
        $data = $this->modelService->getData();

        return $this->render('view', [
            'model' => $data['recall'],
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws \Exception
     */
    public function actionCheck($id)
    {
        $this->modelService->check($id);

        return $this->redirect(['index']);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws \Exception
     */
    public function actionDelete($id)
    {
        $this->modelService->delete($id);

        return $this->redirect(['index']);
    }
}
<?php

namespace admin\controllers;

use admin\services\NoticeService;

class NoticeController extends Controller
{
    /**
     * NoticeController constructor.
     * @param string $id
     * @param $module
     * @param NoticeService $noticeService
     * @param array $config
     */
    public function __construct(string $id, $module, NoticeService $noticeService, array $config = [])
    {
        $this->modelService = $noticeService;

        parent::__construct($id, $module, $config);
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $this->modelService->getDataProvider();
        $data = $this->modelService->getData();

        return $this->render('index', [
            'dataProvider' => $data['provider'],
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     */
    public function actionDelete($id)
    {
        $this->modelService->delete($id);

        return $this->redirect(['index']);
    }
}

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
        $this->modelService->getAllNotices();
        $data = $this->modelService->getData();

        return $this->render('index', [
            'notices' => $data['notices'],
        ]);
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
}

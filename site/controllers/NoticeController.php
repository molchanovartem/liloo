<?php

namespace site\controllers;

use site\services\NoticeService;

/**
 * Class NoticeController
 * @package site\controllers
 */
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
        $this->modelService->getNotices();

        return $this->render('index', [
            'data' => $this->modelService->getData(),
        ]);
    }
}

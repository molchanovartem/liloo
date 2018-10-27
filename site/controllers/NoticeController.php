<?php

namespace site\controllers;

use Yii;

/**
 * Class NoticeController
 * @package site\controllers
 */
class NoticeController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'data' => Yii::$app->siteNotice->getUserNotice(),
        ]);
    }
}

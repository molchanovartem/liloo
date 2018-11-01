<?php

namespace admin\controllers;

use Yii;

/**
 * Class NoticeController
 * @package admin\controllers
 */
class NoticeController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'notices' => Yii::$app->adminNotice->getAllNotice(),
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws \Exception
     */
    public function actionDelete(int $id)
    {
        Yii::$app->adminNotice->delete($id);

        return $this->redirect(['index']);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws \Exception
     */
    public function actionCheck($id)
    {
        Yii::$app->adminNotice->checkNotice($id);

        return $this->redirect(['index']);
    }
}

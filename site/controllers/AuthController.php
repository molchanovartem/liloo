<?php

namespace site\controllers;

use site\forms\LoginForm;
use Yii;

/**
 * Class AuthController
 *
 * @package site\controllers
 */
class AuthController extends Controller
{
    /**
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post() && $model->login())) {
            return $this->goBack();
        }

        return $this->render('site/login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
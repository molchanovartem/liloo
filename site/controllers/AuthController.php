<?php

namespace site\controllers;

use common\services\AuthService;
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
     * AuthController constructor.
     * @param string $id
     * @param $module
     * @param AuthService $userAccessService
     * @param array $config
     */
    public function __construct(string $id, $module, AuthService $userAccessService, array $config = [])
    {
        $this->modelService = $userAccessService;

        parent::__construct($id, $module, $config);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        $model->load(Yii::$app->request->post());
        if ($model->load(Yii::$app->request->post() && $model->login())) {

            return $this->goBack();
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     * @throws \yii\db\Exception
     */
    public function actionRegistration()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if($this->modelService->registration()) {
            return $this->goHome();
        }

        $data = $this->modelService->getData();

        return $this->render('registration', compact($data['model']));
    }
}
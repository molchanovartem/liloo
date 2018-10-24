<?php

namespace site\controllers;

use Yii;
use site\services\AuthService;
use site\forms\LoginForm;

/**
 * Class AuthController
 *
 * @package site\controllers
 */
class AuthController extends Controller
{
    public $layout = 'static';
    public $mainLayout = '/layouts/option/auth';

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
     * @return array
     */
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'transparent' => true,
                'width' => 150,
                'height' => 75,
            ],
        ];
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['/dashboard']);
        }

        if ($this->modelService->login()) {
            return $this->redirect(['/dashboard']);
        }

        $data = $this->modelService->getData();

        return $this->render('login', [
            'model' => $data['model'],
        ]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(['/site/index']);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     * @throws \yii\db\Exception
     */
    public function actionRegistration()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['/dashboard']);
        }

        if ($this->modelService->registration()) {
            return $this->redirect(['/']);
        }

        $data = $this->modelService->getData();

        return $this->render('registration', [
            'model' => $data['model']
        ]);
    }
}

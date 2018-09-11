<?php

namespace site\controllers;

use Yii;
use Exception;
use common\services\UserAccessService;

/**
 * Class UserController
 * @package site\controllers
 */
class UserController extends Controller
{
    /**
     * UserController constructor.
     * @param string $id
     * @param $module
     * @param UserAccessService $userAccessService
     * @param array $config
     */
    public function __construct(string $id, $module, UserAccessService $userAccessService, array $config = [])
    {
        $this->modelService = $userAccessService;

        parent::__construct($id, $module, $config);
    }

    /**
     * @return string|\yii\web\Response
     * @throws Exception
     */
    public function actionSignup()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if($this->modelService->registration()) {
            return $this->goHome();
        }

        $data = $this->modelService->getData();

        return $this->render('signup', compact($data['model']));
    }
}
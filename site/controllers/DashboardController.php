<?php

namespace site\controllers;

use yii\filters\AccessControl;

/**
 * Class DashboardController
 * @package site\controllers
 */
class DashboardController extends Controller
{
    /**
     * @return array
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->extraRender('/dashboard/index');
    }
}

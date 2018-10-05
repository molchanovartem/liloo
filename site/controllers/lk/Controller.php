<?php

namespace site\controllers\lk;

use yii\filters\AccessControl;

class Controller extends \site\controllers\Controller
{
    public $layout = 'mainTwoColumns';

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
}
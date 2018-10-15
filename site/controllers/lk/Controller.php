<?php

namespace site\controllers\lk;

use yii\filters\AccessControl;

/**
 * Class Controller
 *
 * @package site\controllers\lk
 */
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
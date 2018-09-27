<?php

namespace site\controllers;

use common\models\Specialization;

/**
 * Class SiteController
 *
 * @package site\controllers
 */
class SiteController extends Controller
{
    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $specializations = Specialization::find()->all();

        return $this->extraRender('index', [
            'specializations' => $specializations,
        ]);
    }
}

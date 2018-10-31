<?php

namespace site\controllers;

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
        $this->layout = 'static';
        $this->mainLayout = '/layouts/option/girl';

        return $this->extraRender('index', [
            'modelService' => $this->modelService
        ]);
    }

    /**
     * @return array|string
     */
    public function actionRecalls()
    {
        $this->layout = 'staticRecall';
        return $this->extraRender('recalls');
    }
}

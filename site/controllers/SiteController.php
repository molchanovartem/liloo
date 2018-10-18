<?php

namespace site\controllers;

/**
 * Class SiteController
 *
 * @package site\controllers
 */
class SiteController extends Controller
{
    public $layout = 'static';

    public $mainLayout = '/layouts/option/girl';

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->extraRender('index', [
            'modelService' => $this->modelService
        ]);
    }
}

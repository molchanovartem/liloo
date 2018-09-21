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
        return $this->render('index');
    }
}

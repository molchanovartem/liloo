<?php

namespace admin\core\service;

use Yii;

abstract class ViewService extends Service
{
    public function getView()
    {
        return Yii::$app->view;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 07.07.2017
 * Time: 20:43
 */

namespace admin\core\service;


use Yii;

abstract class ViewService extends Service
{
    public function getView()
    {
        return Yii::$app->view;
    }
}
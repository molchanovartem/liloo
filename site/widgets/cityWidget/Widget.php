<?php

namespace site\widgets\cityWidget;

/**
 * Class Widget
 *
 * @package site\widgets\cityWidget
 */
class Widget extends \yii\base\Widget
{
    public function run()
    {
        $this->view->registerJs('cityWidget();');

        return $this->render('index');
    }
}
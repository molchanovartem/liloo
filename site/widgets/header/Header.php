<?php

namespace site\widgets\header;

use yii\base\Widget;

class Header extends Widget
{
    public function run()
    {
        return $this->render('index');
    }
}
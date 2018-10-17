<?php

namespace site\widgets\header;

use yii\base\Widget;

/**
 * Class Header
 * @package site\widgets\header
 */
class Header extends Widget
{
    /**
     * @return string
     */
    public function run()
    {
        return $this->render('index');
    }
}

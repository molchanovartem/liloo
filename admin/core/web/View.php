<?php

namespace admin\core\web;

class View extends \yii\web\View
{
    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title ?? '';
    }
}

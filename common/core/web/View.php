<?php

namespace common\core\web;

/**
 * Class View
 * @package common\core\web
 */
class View extends \yii\web\View
{
    private $heading = null;

    private $breadcrumbs = [];

    /**
     * @param array $breadcrumbs
     */
    public function setBreadcrumbs(array $breadcrumbs)
    {
        $this->breadcrumbs = $breadcrumbs;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getBreadcrumbs()
    {
        return $this->breadcrumbs ?? [];
    }

    /**
     * @param $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title ?? '';
    }

    /**
     * @return null
     */
    public function getHeading()
    {
        return $this->heading;
    }

    /**
     * @param null $heading
     */
    public function setHeading($heading)
    {
        $this->heading = $heading;
    }
}

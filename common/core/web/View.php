<?php

namespace common\core\web;

use site\widgets\breadcrumbs\Breadcrumbs;

/**
 * Class View
 * @package common\core\web
 */
class View extends \yii\web\View
{
    private $breadcrumbs;

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
        return Breadcrumbs::widget([
            'links' => isset($this->breadcrumbs) ? $this->breadcrumbs : [],
        ]);
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
}

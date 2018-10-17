<?php

namespace site\widgets\breadcrumbs;

/**
 * Class Breadcrumbs
 */
class Breadcrumbs extends \yii\widgets\Breadcrumbs
{
    public $tag = 'div';

    public $options = ['class' => 'row-categories'];

    public $itemTemplate = '<div class="row-categories__item"><a href="" class="row-categories__link">{link}</a></div>';

    public $activeItemTemplate = '<div class="row-categories__item"><a href="" class="row-categories__link row-categories__link_current">{link}</a></div>';
}

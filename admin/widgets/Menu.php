<?php

namespace admin\widgets;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Class Menu
 * @package app\modules\lk\widgets
 */
class Menu extends \yii\widgets\Menu
{
    public $linkTemplate = '<a href="{url}" {options}>{icon} {label}</a>';

    protected function renderItem($item)
    {
        if (isset($item['url'])) {
            $template = ArrayHelper::getValue($item, 'template', $this->linkTemplate);

            return strtr($template, [
                '{url}' => Html::encode(Url::to($item['url'])),
                '{label}' => $item['label'],
                '{icon}' => isset($item['icon']) ? Html::tag('i', '', ['class' => $item['icon']]) : '',
                '{options}' => isset($item['linkOptions']) ? Html::renderTagAttributes($item['linkOptions']) : '',
            ]);
        } else {
            $template = ArrayHelper::getValue($item, 'template', $this->labelTemplate);

            return strtr($template, [
                '{label}' => $item['label'],
            ]);
        }
    }
}
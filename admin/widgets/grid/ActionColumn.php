<?php

namespace app\modules\lk\widgets\grid;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Class ActionColumn
 * @package app\modules\lk\widgets\grid
 */
class ActionColumn extends \yii\grid\ActionColumn
{
    public $contentOptions = ['class' => 'lk-grid-column-action'];

    public $buttonsOptions = [];

    protected function initDefaultButtons()
    {
        $this->initDefaultButton('view', 'eye');
        $this->initDefaultButton('update', 'pencil');
        $this->initDefaultButton('delete', 'trash', [
            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
            'data-method' => 'post',
        ]);
    }

    protected function initDefaultButton($name, $iconName, $additionalOptions = [])
    {
        if (!isset($this->buttons[$name]) && strpos($this->template, '{' . $name . '}') !== false) {
            $this->buttons[$name] = function ($url, $model, $key) use ($name, $iconName, $additionalOptions) {
                switch ($name) {
                    case 'view':
                        $title = Yii::t('yii', 'View');
                        break;
                    case 'update':
                        $title = Yii::t('yii', 'Update');
                        break;
                    case 'delete':
                        $title = Yii::t('yii', 'Delete');
                        break;
                    default:
                        $title = ucfirst($name);
                }

                $options = array_merge([
                    'title' => $title,
                    'aria-label' => $title,
                    'data-pjax' => '0',
                ], $additionalOptions, $this->buttonOptions);

                if (isset($this->buttonsOptions[$name])) {
                    $class = ArrayHelper::removeValue($this->buttonsOptions[$name], 'class');
                    Html::addCssClass($this->buttonOptions, $class);
                    $options = array_merge($options, $this->buttonsOptions[$name]);
                }

                $icon = Html::tag('span', '', ['class' => "fa fa-$iconName"]);
                return Html::a($icon, $url, $options);
            };
        }
    }
}
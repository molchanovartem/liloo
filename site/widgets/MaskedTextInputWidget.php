<?php

namespace site\widgets;

use yii\helpers\Html;
use yii\widgets\InputWidget;

/**
 * Class MaskedTextInputWidget
 * @package site\widgets
 */
class MaskedTextInputWidget extends InputWidget
{
    public $pattern = null;

    /**
     * @return string
     */
    public function run()
    {
        $this->registerScriptJs();

        if ($this->hasModel()) {
            return Html::activeTextInput($this->model, $this->attribute, $this->options);
        }
        return Html::textInput($this->name, $this->value, $this->options);
    }

    protected function registerScriptJs()
    {
        $id = $this->options['id'];
        $pattern = $this->pattern;
        $script = "VMasker(document.getElementById('{$id}')).maskPattern('{$pattern}')";
        $this->view->registerJs($script);
    }
}
<?php

namespace admin\widgets\activeField;

use yii\helpers\Html;

class ActiveField extends \yii\widgets\ActiveField
{
    public $options = ['class' => 'uk-margin-small-bottom'];

    public $template = "{label}\n{containerInput}";
    /**
     * @var array
     */
    public $containerInputOptions = ['class' => 'container-input'];


    public $inputOptions = ['class' => 'uk-form-small'];
    /**
     * @var string
     */
    public $inputCssClass = 'uk-input';
    /**
     * @var string
     */
    public $textareaCssClass = 'uk-textarea';
    /**
     * @var string
     */
    public $dropDownListCssClass = 'uk-select';
    /**
     * @var string
     */
    public $radioCssClass = 'uk-radio';
    /**
     * @var string
     */
    public $checkboxCssClass = 'uk-checkbox';

    /**
     * @var array the default options for the label tags. The parameter passed to [[label()]] will be
     * merged with this property when rendering the label tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $labelOptions = ['class' => 'uk-form-label'];

    public function render($content = null)
    {
        if ($content === null) {
            if (!isset($this->parts['{input}'])) {
                $this->textInput();
            }
            if (!isset($this->parts['{containerInput}'])) {
                $this->containerInput();
            }
            if (!isset($this->parts['{label}'])) {
                $this->label();
            }
            $content = strtr($this->template, $this->parts);
        } elseif (!is_string($content)) {
            $content = call_user_func($content, $this);
        }
        return $this->begin() . "\n" . $content . "\n" . $this->end();
    }

    protected function containerInput()
    {
        $this->parts['{containerInput}'] = Html::tag('div', $this->parts['{input}'], $this->containerInputOptions);
    }

    public function passwordInput($options = [])
    {
        $options = array_merge($this->inputOptions, $options);
        Html::addCssClass($options, $this->inputCssClass);

        $this->parts['{input}'] = Html::activePasswordInput($this->model, $this->attribute, $options);

        return $this;
    }

    public function textInput($options = [])
    {
        $options = array_merge($this->inputOptions, $options);
        Html::addCssClass($options, $this->inputCssClass);

        $this->parts['{input}'] = Html::activeTextInput($this->model, $this->attribute, $options);

        return $this;
    }

    public function textarea($options = [])
    {
        $options = array_merge($this->inputOptions, $options);
        Html::addCssClass($options, $this->textareaCssClass);

        $this->parts['{input}'] = Html::activeTextarea($this->model, $this->attribute, $options);

        return $this;
    }

    public function radio($options = [], $enclosedByLabel = true)
    {
        Html::addCssClass($options, $this->radioCssClass);

        if ($enclosedByLabel) {
            $this->parts['{input}'] = Html::activeRadio($this->model, $this->attribute, $options);
            $this->parts['{label}'] = '';
        } else {
            if (isset($options['label']) && !isset($this->parts['{label}'])) {
                $this->parts['{label}'] = $options['label'];
                if (!empty($options['labelOptions'])) {
                    $this->labelOptions = $options['labelOptions'];
                }
            }
            unset($options['labelOptions']);
            $options['label'] = null;
            $this->parts['{input}'] = Html::activeRadio($this->model, $this->attribute, $options);
        }
        $this->adjustLabelFor($options);

        return $this;
    }

    public function checkbox($options = [], $enclosedByLabel = true)
    {
        Html::addCssClass($options, $this->checkboxCssClass);

        if ($enclosedByLabel) {
            $this->parts['{input}'] = Html::activeCheckbox($this->model, $this->attribute, $options);
            $this->parts['{label}'] = '';
        } else {
            if (isset($options['label']) && !isset($this->parts['{label}'])) {
                $this->parts['{label}'] = $options['label'];
                if (!empty($options['labelOptions'])) {
                    $this->labelOptions = $options['labelOptions'];
                }
            }
            unset($options['labelOptions']);
            $options['label'] = null;
            $this->parts['{input}'] = Html::activeCheckbox($this->model, $this->attribute, $options);
        }
        $this->adjustLabelFor($options);

        return $this;
    }

    public function dropDownList($items, $options = [])
    {
        $options = array_merge($this->inputOptions, $options);
        Html::addCssClass($options, $this->dropDownListCssClass);

        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::activeDropDownList($this->model, $this->attribute, $items, $options);

        return $this;
    }
}
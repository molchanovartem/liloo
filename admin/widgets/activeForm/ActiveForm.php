<?php

namespace admin\widgets\activeForm;

use Yii;
use yii\base\InvalidCallException;
use yii\helpers\Html;

class ActiveForm extends \yii\widgets\ActiveForm
{
    public $fieldClass = 'admin\widgets\activeField\ActiveField';

    public $fieldConfig = [
        'template' => "{label}\n{containerInput}",
        'containerInputOptions' => ['class' => 'uk-form-controls']
    ];
    /**
     * @var bool
     */
    public $encodeErrorSummary = true;
    /**
     * @var string
     */
    public $errorSummaryCssClass = 'error-summary uk-alert-danger';
    /**
     * @var string
     */
    public $errorCssClass = 'has-error';
    /**
     * @var array
     */
    public $errorSummaryListOptions = ['class' => 'uk-list uk-text-small uk-padding-small'];

    public $buttons = [];

    public $buttonsContainerOptions = ['class' => 'uk-margin'];

    public function run()
    {
        if (!empty($this->fields)) {
            throw new InvalidCallException('Each beginField() should have a matching endField() call.');
        }
        $content = ob_get_clean();

        $this->registerClientScript();

        echo Html::beginForm($this->action, $this->method, $this->options);
        echo $content;

        $buttons = Html::submitButton(Yii::t('app', 'Save'), [
            'class' => 'uk-button uk-button-small uk-button-primary'
        ]);
        if ($this->buttons) {
            $buttons = implode(' ', $this->buttons);
        }
        echo Html::tag('div', $buttons, $this->buttonsContainerOptions);
        echo Html::endForm();
    }
}
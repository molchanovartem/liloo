<?php

namespace site\widgets\activeForm;

/**
 * Class ActiveForm
 * @package site\widgets\activeForm
 */
class ActiveForm extends \yii\widgets\ActiveForm
{
    public $fieldClass = 'site\widgets\activeField\ActiveField';

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
}

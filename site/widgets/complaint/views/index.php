<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<button class="uk-button uk-button-default" type="button">Пожаловаться</button>

<div uk-dropdown="mode: click">

    <?php $form = ActiveForm::begin([
        'action' => \yii\helpers\Url::to(['recall/complaint']),
        'enableClientScript' => false,
        'options' => [
            'onSubmit' => 'recallComplaintFormOnSubmit(this);return false;'
        ]
    ]); ?>

    <?php echo $form->field($model, 'recallId')->hiddenInput(['value' => $recallId])->label(false); ?>

    <b>С этим отзывом что-то не так ?</b>

    <div class="uk-margin-top">
        <?php echo $form->field($model, 'reason')
            ->radioList($complaintList, ['separator' => '<br>', 'encode' => false])
            ->label(false);
        ?>
    </div>

    <?php echo Html::submitButton('Отправить', [
        'class' => 'uk-button uk-button-primary uk-button-small uk-margin-top',
    ]); ?>

    <?php ActiveForm::end(); ?>

</div>

<script>
    function recallComplaintFormOnSubmit(form) {
        var $form = $(form);
        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            data: $form.serialize()
        }).done(function () {
            UIkit.notification({
                message: 'Жалоба направлена на рассмотрение.',
                status: 'success'
            })
        }).fail(function () {
            console.log('fail');
        });
    }
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>
<?php
$time
?>

<div class="uk-container">
    <div class="user-form">

        <?php

        use admin\widgets\activeForm\ActiveForm;
        use yii\jui\DatePicker;

        $form = ActiveForm::begin([
            'enableClientValidation' => false,
            'method' => 'get',
            'action' => \yii\helpers\Url::to(['executor/index']),
        ]); ?>

        <div class="panel panel-default panel-body">

            <?= $form->errorSummary($data['form']); ?>

            <div class="uk-width-1-5 uk-float-left">
                <?= $form->field($data['form'], 'specialization')
                    ->dropDownList($data['form']->getSpecialization(), [
                        'class' => 'uk-input uk-form-small',
                        'prompt' => '  Выберите специализацию...',
                        'id' => 'specialization-id'
                    ]); ?>
            </div>

            <div class="uk-width-1-5 uk-float-left uk-margin-left">
                <?= $form->field($data['form'], 'city')
                    ->dropDownList($data['form']->getCities(), [
                        'class' => 'uk-input uk-form-small',
                        'prompt' => '  Выберите специализацию...',
                        'id' => 'city-id'
                    ]); ?>
            </div>

            <div class="uk-width-1-5 uk-float-left uk-margin-left">
                <?= $form->field($data['form'], 'date')->widget(DatePicker::class, [
                    'options' => [
                        'class' => 'uk-input uk-form-small',
                    ],
                    'dateFormat' => 'yyyy-MM-dd',
                ]) ?>
            </div>

            <div class="uk-width-1-5 uk-float-left uk-margin-left">
                <?= $form->field($data['form'], 'time')
                    ->dropDownList($data['form']->getTime(), [
                        'class' => 'uk-input uk-form-small',
                        'prompt' => '  Выберите специализацию...',
                        'id' => 'time',
                        'multiple' => 'multiple',
                    ]); ?>
            </div>
            <br><br><br>
        </div>
        <?php ActiveForm::end(); ?>

    </div>

    <div class="uk-margin-top">
        <?= $this->render('_listView', ['data' => $data]); ?>
    </div>
</div>

<script>
    $("#specialization-id").select2({
        selectOnClose: true
    });
    $("#city-id").select2({
        selectOnClose: true
    });
    $('#time').select2({
        placeholder: 'Время',
        allowClear: true
    });
</script>
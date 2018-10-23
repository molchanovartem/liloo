<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<?php

use admin\widgets\activeForm\ActiveForm;

$this->setBreadcrumbs([
    ['label' => 'Профиль', 'url' => ['view']],
    'Изменение личных данных',
]);
?>


    <div class="uk-margin-top content-columns__column content-column__column_main">

        <div class="content-block p-40 content-block_shadow uk-background-default">

            <div class="j-c_s-b">
                <div class="content-block__title">Редактирование профиля</div>
            </div>

            <?php $form = ActiveForm::begin(['enableClientValidation' => false]); ?>

            <div class="panel panel-default panel-body">

                <?= $form->errorSummary($data['model']); ?>

                <?= $form->field($data['model'], 'name')->textInput(['maxlength' => true]) ?>
                <?= $form->field($data['model'], 'surname')->textInput(['maxlength' => true]) ?>

                <div class="uk-form-controls">
                    <?= $form->field($data['model'], 'date_birth')->widget(\yii\jui\DatePicker::class, [
                        'dateFormat' => 'yyyy-MM-dd',
                        'options' => ['class' => 'uk-form-small uk-input'],
                        'clientOptions' => [
                            'changeYear' => 'true',
                            'changeMonth' => 'true',
                        ]
                    ]) ?>
                </div>

                <?= $form->field($data['model'], 'phone')->textInput(['maxlength' => true]) ?>
                <!--                    --><? //= $form->field($data['model'], 'phone')->widget(\yii\widgets\MaskedInput::class, [
                //                        'mask' => '+7 (999) 999-99-99',
                //                        'options' => [
                //                            'class' => 'uk-form-small uk-input',
                //                            'id' => 'userprofile-phone',
                //                            'placeholder' => ('Телефон')
                //                        ],
                //                        'clientOptions' => [
                //                            'clearIncomplete' => true
                //                        ]
                //                    ]); ?>

                <div class="uk-width-small">
                    <?= $form->field($data['model'], 'city_id')
                        ->dropDownList($data['cities'], [
                            'class' => 'uk-input uk-form-small ',
                            'prompt' => '  Выберите город...',
                            'id' => 'city-id',
                        ]); ?>
                </div>

                <div class="uk-width-small">
                    <?= $form->field($data['model'], 'country_id')
                        ->dropDownList($data['countries'], [
                            'class' => 'uk-input uk-form-small',
                            'prompt' => '  Выберите город...',
                            'id' => 'country-id',
                        ]); ?>
                </div>

            </div>

            <?php ActiveForm::end(); ?>

        </div>

    </div>

<script>
    $("#city-id").select2({
        selectOnClose: true
    });

    $("#country-id").select2({
        selectOnClose: true
    });
</script>
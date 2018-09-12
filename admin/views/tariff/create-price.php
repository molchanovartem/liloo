<?php

use admin\widgets\activeForm\ActiveForm;

$this->setTitle('Добавление цены');
$this->params['breadcrumbs'][] = ['label' => 'Тарифы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="interaction-create">

    <div class="interaction-form">

        <?php $form = ActiveForm::begin(); ?>

        <div class="panel panel-default panel-body">

            <?= $form->field($model, 'tariff_id')->hiddenInput()->label(false); ?>

            <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'days')->textInput(['maxlength' => true]) ?>

        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>

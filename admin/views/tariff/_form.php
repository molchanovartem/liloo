<?php

use admin\widgets\activeForm\ActiveForm;

?>

<div class="tariff-form">

    <?php $form = ActiveForm::begin(['enableClientValidation' => false]); ?>

    <div class="panel panel-default panel-body">

        <?= $form->errorSummary($model); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'description')->textarea(['rows' => '3']) ?>


        <?= $form->field($model, 'type')->dropDownList($model->getTypes(), ['prompt' => 'Выберите тип...']); ?>

        <?= $form->field($model, 'status')->dropDownList($model->getStatuses(), ['prompt' => 'Выберите статус...']); ?>


        <?= $form->field($model, 'quantity')->textInput(['maxlength' => true]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

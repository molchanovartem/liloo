<?php

use admin\widgets\activeForm\ActiveForm;
use admin\forms\TariffForm;

?>

<div class="tariff-form">

    <?php $form = ActiveForm::begin(['enableClientValidation' => false]); ?>

    <div class="panel panel-default panel-body">

        <?= $form->errorSummary($data['form']); ?>

        <?= $form->field($data['form'], 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($data['form'], 'description')->textarea(['rows' => '3']) ?>


        <?= $form->field($data['form'], 'type')->dropDownList($data['form']->getTypeList(), ['prompt' => 'Выберите тип...']); ?>

        <?= $form->field($data['form'], 'status')->dropDownList($data['form']->getStatusList(), ['prompt' => 'Выберите статус...']); ?>


        <?= $form->field($data['form'], 'quantity')->textInput(['maxlength' => true]) ?>

        <?= $form->field($data['form'], 'access')->checkboxList(TariffForm::getTariffAccessList(), ['separator' => '<br>']) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>

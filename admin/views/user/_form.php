<?php

use admin\widgets\activeForm\ActiveForm;

?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['enableClientValidation' => false]); ?>

    <div class="panel panel-default panel-body">

        <?= $form->errorSummary($model); ?>

        <?= $form->field($model, 'login')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'role')->dropDownList($model->getRoles(), ['prompt' => 'Выберите роль...']); ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>

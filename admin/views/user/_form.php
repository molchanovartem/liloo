<?php

use admin\widgets\activeForm\ActiveForm;

?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="panel panel-default panel-body">

        <?= $form->field($model, 'login')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'role')->dropDownList(['0' => 'Суперадмин', '1' => 'Админ'], ['prompt' => 'Выберите роль...']); ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>

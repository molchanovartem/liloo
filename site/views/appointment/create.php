<?php

use admin\widgets\activeForm\ActiveForm;

?>
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js"></script>

<div class="user-form">

    <?php $form = ActiveForm::begin(['enableClientValidation' => false]); ?>

    <div class="panel panel-default panel-body">

        <?= $form->errorSummary($model); ?>

        <?= $form->field($model, 'start_date')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'end_date')->passwordInput(['maxlength' => true]) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>

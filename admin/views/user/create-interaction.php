<?php

use admin\widgets\activeForm\ActiveForm;

$this->setTitle('Добавление комментария');
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="interaction-create">

    <div class="interaction-form">

        <?php $form = ActiveForm::begin(); ?>

        <div class="panel panel-default panel-body">

            <?= $form->field($model, 'user_id')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'comment')->textarea(['rows' => '6']) ?>

        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>

<?php

use admin\widgets\activeForm\ActiveForm;

$this->setBreadcrumbs([
    ['label' => 'Профиль', 'url' => ['view']],
    'Сброс пароля',
]);
?>

<div class="uk-margin-top content-columns__column content-column__column_main">
    <div class="content-block p-40 content-block_shadow uk-background-default">
        <div class="j-c_s-b uk-margin-bottom">
            <div class="content-block__title">Сброс пароля</div>
        </div>

        <?php $form = ActiveForm::begin(['enableClientValidation' => false]); ?>

        <div class="panel panel-default panel-body">

            <?= $form->errorSummary($data['model']); ?>

            <?= $form->field($data['model'], 'oldPassword')->passwordInput(['maxlength' => true]) ?>
            <?= $form->field($data['model'], 'newPassword')->passwordInput(['maxlength' => true]) ?>
            <?= $form->field($data['model'], 'repeatNewPassword')->passwordInput(['maxlength' => true]) ?>

        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

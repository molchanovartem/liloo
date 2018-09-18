<!--<form class="uk-grid uk-grid-small uk-margin-top">-->
<!---->
<!--    <legend class="uk-legend">Фильтр</legend>-->
<!---->
<!--    <div class="uk-width-1-4@s uk-margin-top">-->
<!--        <input class="uk-input" type="text" placeholder="Специализация">-->
<!--    </div>-->
<!--    <div class="uk-width-1-4@s uk-margin-top">-->
<!--        <input class="uk-input" type="text" placeholder="Город">-->
<!--    </div>-->
<!--    <div class="uk-width-1-4@s uk-margin-top">-->
<!--        <input class="uk-input" type="text" placeholder="Дата">-->
<!--    </div>-->
<!--    <div class="uk-width-1-4@s uk-margin-top">-->
<!--        <input class="uk-input" type="text" placeholder="Время">-->
<!--    </div>-->
<!--    -->
<!--</form>-->


<div class="user-form">

    <?php use admin\widgets\activeForm\ActiveForm;

    $form = ActiveForm::begin(['enableClientValidation' => false]); ?>

    <div class="panel panel-default panel-body">

        <?= $form->errorSummary($model); ?>

        <?= $form->field($model, 'specialization')->dropDownList($model->getSpecialization(), ['prompt' => 'Выберите специализацию...']); ?>

        <?= $form->field($model, 'specialization')->dropDownList($model->getCities(), ['prompt' => 'Выберите город...']); ?>

        <?= $form->field($model, 'date')->widget(\yii\jui\DatePicker::class, [
            'language' => 'ru',
            'dateFormat' => 'yyyy-MM-dd',
        ]) ?>


    </div>

    <?php ActiveForm::end(); ?>

</div>

<div class="uk-margin-top">
    <?= $this->render('_listView', ['provider' => $provider]); ?>
</div>

<?php var_dump($provider) ?>
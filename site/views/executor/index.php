<div class="uk-container">
    <div class="user-form">

        <?php

        use admin\widgets\activeForm\ActiveForm;
        use yii\jui\DatePicker;
        use yii\jui\AutoComplete;

        $form = ActiveForm::begin(['enableClientValidation' => false,'method' => 'get']); ?>

        <div class="panel panel-default panel-body">

            <?= $form->errorSummary($model); ?>

            <?= $form->field($model, 'specialization')->dropDownList($model->getSpecialization(), ['value' => Yii::$app->request->get('specialization'), 'prompt' => 'Выберите специализацию...']); ?>

            <?= $form->field($model, 'city')->widget(
                AutoComplete::class, [
                'clientOptions' => [
                    'source' => $model->getCities(),
                ],
                'options' => [
                    'class' => 'form-control',
                ],
            ]);
            ?>

            <?= $form->field($model, 'date')->widget(DatePicker::class, [
                'dateFormat' => 'MM-dd-yyyy',
            ]) ?>

            <?= $form->field($model, 'time')->textInput(['maxlength' => true]) ?>

        </div>

        <?php ActiveForm::end(); ?>

    </div>

    <div class="uk-margin-top">
        <?= $this->render('_listView', ['provider' => $provider]); ?>
    </div>
</div>

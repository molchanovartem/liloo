<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>
<?php

use site\forms\FilterForm;

?>

<div class="uk-container">
    <div class="user-form">

        <?php

        use admin\widgets\activeForm\ActiveForm;
        use yii\jui\DatePicker;

        $form = ActiveForm::begin([
            'enableClientValidation' => false,
            'method' => 'get',
            'action' => \yii\helpers\Url::to(['executor/index']),
        ]); ?>

        <div class="panel panel-default panel-body">

            <?= $form->errorSummary($data['form']); ?>

            <div class="uk-width-1-6 uk-float-left">
                <?= $form->field($data['form'], 'specialization')
                    ->dropDownList($data['form']->getSpecialization(), [
                        'class' => 'uk-input uk-form-small',
                        'prompt' => '  Выберите специализацию...',
                        'id' => 'specialization-id',
                    ]); ?>
            </div>

            <div class="uk-width-1-6 uk-float-left uk-margin-left">
                <?= $form->field($data['form'], 'service')
                    ->dropDownList([], [
                        'class' => 'uk-input uk-form-small',
                        'id' => 'service-id',
                        'data-selected' => $data['form']->service
                    ]); ?>
            </div>

            <div class="uk-width-1-6 uk-float-left uk-margin-left">
                <?= $form->field($data['form'], 'city')
                    ->dropDownList($data['form']->getCities(), [
                        'class' => 'uk-input uk-form-small',
                        'prompt' => '  Выберите специализацию...',
                        'id' => 'city-id'
                    ]); ?>
            </div>

            <div class="uk-width-1-6 uk-float-left uk-margin-left">
                <?= $form->field($data['form'], 'date')->widget(DatePicker::class, [
                    'options' => [
                        'class' => 'uk-input uk-form-small',
                    ],
                    'dateFormat' => 'yyyy-MM-dd',
                ]) ?>
            </div>

            <div class="uk-width-1-6 uk-float-left uk-margin-left">
                <?= $form->field($data['form'], 'time')
                    ->dropDownList(FilterForm::getPartTime(), [
                        'class' => 'uk-input uk-form-small',
                        'prompt' => '  Выберите специализацию...',
                        'id' => 'time',
                        'multiple' => 'multiple',
                    ]); ?>
            </div>
            <br><br><br>
        </div>
        <?php ActiveForm::end(); ?>

    </div>

    <div class="uk-margin-top">
        <?= $this->render('_listView', ['data' => $data]); ?>
    </div>
</div>

<script>
    'use strict';

    const commonServices = <?= json_encode($data['form']->getServices(), true);?>;

    let $specialization = $("#specialization-id").select2({
        selectOnClose: true
    });

    let $service = $("#service-id").select2({
        selectOnClose: true,
    });

    $("#city-id").select2({
        selectOnClose: true
    });
    $('#time').select2({
        placeholder: 'Время',
        allowClear: true
    });

    $specialization.on('change.select2', function (e) {
        appendServices(getServices(e.target.value || null));
    });
    $specialization.trigger('change.select2');

    function getServices(specializationId = null) {
        let services = commonServices.filter(items => {
            if (specializationId === null) return true;

            return +items.specialization_id === +specializationId;
        });
        return services.map(item => {
            return {id: item.id, text: item.name};
        });
    }

    function appendServices(services) {
        $service.html('');

        $service.append(new Option('Выберите услугу...', '', true));
        services.forEach(item => {
            let selected = +item.id === $service.data('selected');

            $service.append(new Option(item.text, item.id, false, selected));
        });
    }
</script>
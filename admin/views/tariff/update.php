<?php

$this->setTitle('Изменение: ' . $model->name);
$this->params['breadcrumbs'][] = ['label' => 'Тарифы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменение';
?>
<div class="tariff-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

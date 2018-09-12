<?php

$this->setTitle('Создание нового тарифа');
$this->params['breadcrumbs'][] = ['label' => 'Тарифы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tariff-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

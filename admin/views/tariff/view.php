<?php

use yii\helpers\Html;
use admin\widgets\detailView\DetailView;

$this->setTitle($model->name);

$this->params['breadcrumbs'][] = ['label' => 'Тарифы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tariff-view">
    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'uk-button uk-button-default uk-button-small']) ?>
        <?=
        Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'uk-button uk-button-danger uk-button-small',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить этот тариф?',
                'method' => 'post',
            ],
        ])
        ?>
    </p>

    <div>
        <?=
        DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'name',
                'description',
                [
                    'label' => 'Тип',
                    'value' => $model->getTypeName(),
                ],
                [
                    'label' => 'Статус',
                    'value' => $model->getStatusName(),
                ],
                'quantity',
            ],
        ])
        ?>
    </div>

    <h3 class="uk-margin-remove-top">Доступы</h3>

    <div class="uk-grid uk-grid-small uk-child-width-1-4 uk-margin-top">
        <ul class="uk-list uk-list-striped">
            <?php foreach ($model->accessArray as $access): ?>
                <li><?php echo $model->getTariffAccessList()[$access]; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="uk-margin-top">
        <?= Html::a('<span class="uk-margin-small-right" uk-icon="plus"></span> Добавить цену', ['/tariff/create-price?tariffId=' . $model->id], ['class' => 'uk-button uk-button-default uk-button-small']) ?>
    </div>

    <div class="uk-grid uk-grid-small uk-child-width-1-4 uk-margin-top">
        <ul class="uk-list uk-list-striped">
            <?php foreach ($prices as $price): ?>
                <li>Количество дней: <?php echo $price->days; ?> - Цена: <?php echo $price->price; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
